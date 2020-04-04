<?php

namespace App\Http\Controllers;

use App\Application;
use App\File;
use App\Http\Requests\AddMessageManager;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        else $application->orderByDesc('status');
        $res = $application->orderByDesc('id')->paginate();
        return view('manager.index', ['applications' => $res]);
    }

    public function show (Application $application)
    {
        $application->updateView();

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
        if (!empty($request->hasFile('attachments'))) {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->store('/', 'public');
                File::create([
                    'message_id' => $message->id,
                    'name' => $name,
                    'path' => $path
                ]);
            }
        }
        return redirect(route('m-show', ['application' => $application]));
    }
}
