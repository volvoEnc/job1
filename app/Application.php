<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    protected $fillable = [
      'user_id', 'subject', 'status', 'view', 'answered'
    ];

    protected $perPage = 10;

    public function manager ()
    {
        return $this->belongsTo(User::class);
    }
    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function addManager ()
    {
        if (empty($this->manager)) {
            $this->manager_id = Auth::user()->id;
            $this->save();
        }
    }

    public function answer($type)
    {
        if ($this->answered != $type) {
            $this->answered = $type;
            $this->save();
        }
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('id');
    }

    public function subjectForList() {
        if (mb_strlen($this->subject) > 30) {
            return substr($this->subject, 0, 25) . '...';
        }
        return $this->subject;
    }

    public function updateView($view = true)
    {
        if ($this->view != $view) {
            $this->view = $view;
            $this->save();
        }
    }

    public function lastMessageFromManager()
    {
        if ($this->messages->last()->user->role == 'manager') {
            return true;
        }
        return false;
    }
}
