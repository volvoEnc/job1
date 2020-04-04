<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    protected $perPage = 10;

    public function manager ()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('id');
    }


    public function subjectForList() {
        return substr($this->subject, 0, 25) . '...';
    }

    public function updateView()
    {
        if ($this->view == false) {
            $this->view = true;
            $this->save();
        }
    }
}
