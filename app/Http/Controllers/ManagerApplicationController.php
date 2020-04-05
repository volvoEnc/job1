<?php

namespace App\Http\Controllers;

use App\Application;
use App\File;
use App\Http\Requests\AddMessageManager;
use App\Mail\ClosedApplicationFromManager;
use App\Mail\CreateMessageFromManager;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ManagerApplicationController extends Controller
{

    public function __construct()
    {
        $this->middleware('CheckManager');
        $this->middleware('auth');
    }

    public function index (Request $request)
    {
        $application = Application::query();
        if ($request->input('filter') == 'close') $application->where('status', 'close');
        elseif ($request->input('filter') == 'open') $application->where('status', 'open')->orderBy('view');
        elseif ($request->input('filter') == 'view') $application->where('view', true)->orderByDesc('id');
        elseif ($request->input('filter') == 'no-view') $application->where('view', false)->where('status', 'open')->orderByDesc('id');
        elseif ($request->input('filter') == 'no-answered') $application->where('answered', 'user');
        elseif ($request->input('filter') == 'answered') $application->where('answered', 'manager');
        else $application->orderByDesc('status')->orderBy('view');
        $application->orderByDesc('id');
        $res = $application->paginate();
        return view('manager.index', ['applications' => $res]);
    }

    public function show (Application $application)
    {
        $application->updateView(true);

        return view('manager.show', [
            'application' => $application
        ]);
    }

    public function update (AddMessageManager $request, Application $application)
    {
        $message = Message::create($request->all() + [
            'user_id' => Auth::user()->id,
            'application_id' => $application->id,
            ]);
        $application->addManager();
        $application->answer('manager');
        File::addAttachments($request, $message);
        Mail::to($application->user->email)->send(new CreateMessageFromManager($application));
        return redirect(route('m-show', [
            'application' => $application,
            'preview-page' => $request->input('page')
        ]));
    }

    public function close (Request $request, Application $application)
    {
        $application->status = 'close';
        $application->save();

        Mail::to($application->user->email)->send(new ClosedApplicationFromManager($application));

        return redirect(route('m-show', [
            'application' => $application,
            'preview-page' => $request->input('page')
        ]));
    }
}
