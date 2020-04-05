<?php

namespace App\Http\Controllers;

use App\Application;
use App\File;
use App\Http\Requests\AddMessageRequest;
use App\Http\Requests\CreateApplicationRequest;
use App\Mail\ClosedApplicationFromManager;
use App\Mail\ClosedApplicationFromUser;
use App\Mail\NewApplicationFromUser;
use App\Mail\NewMessageFromUser;
use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index ()
    {
        $applications = Auth::user()->applications()->orderByDesc('status')->paginate();
        return view('user.index', ['applications' => $applications]);
    }

    public function create ()
    {
//        return view('user.create');
        if(Auth::user()->lastApplicationDate()->diffInHours(Carbon::now()) > 23) {
            return view('user.create');
        }
        return redirect()->back()->withErrors(['alert-danger' => 'Запрос можно отправлять не чаще чем раз в 24 часа']);

    }

    public function store(CreateApplicationRequest $request)
    {
        $application = Application::create([
           'user_id' => Auth::user()->id,
           'subject' => $request->subject,
           'status' => 'open',
           'answered' => 'user',
           'view' => false
        ]);

        $message = Message::create($request->all() + [
                'user_id' => Auth::user()->id,
                'application_id' => $application->id,
            ]);

        File::addAttachments($request, $message);
        $token = \App\AuthToken::create([
            'token' => \Illuminate\Support\Str::random(128),
            'user_id' => User::query()->where('email', env('MANAGER_EMAIL'))->first()->id
        ]);
        Mail::to(['razumkov@e1.ru', env('MANAGER_EMAIL')])->send(new NewApplicationFromUser($application, $token));

        return redirect(route('list'));
    }

    public function show (Request $request, Application $application)
    {
        if ($application->user_id != Auth::user()->id) return redirect(route('list'))->withErrors(['alert-danger' => 'Это чужое ;)']);
        return view('user.show', [
            'application' => $application,
            'preview-page' => $request->input('page')
        ]);
    }

    public function update (AddMessageRequest $request, Application $application)
    {
        $message = Message::create($request->all() + [
                'user_id' => Auth::user()->id,
                'application_id' => $application->id,
            ]);
        $application->updateView(false);
        $application->answer('manager');
        File::addAttachments($request, $message);
        $token = \App\AuthToken::create([
            'token' => \Illuminate\Support\Str::random(128),
            'user_id' => User::query()->where('email', env('MANAGER_EMAIL'))->first()->id
        ]);
        Mail::to(['razumkov@e1.ru', env('MANAGER_EMAIL')])->send(new NewMessageFromUser($application, $token));
        return redirect(route('show', [
            'application' => $application,
            'preview-page' => $request->input('page')
        ]));
    }


    public function close (Request $request, Application $application)
    {
        $application->status = 'close';
        $application->save();

        Mail::to(['razumkov@e1.ru', env('MANAGER_EMAIL')])->send(new ClosedApplicationFromUser($application));

        return redirect(route('show', [
            'application' => $application,
            'preview-page' => $request->input('page')
        ]));
    }

}
