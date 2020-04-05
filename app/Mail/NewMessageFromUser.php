<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMessageFromUser extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param $application
     * @param $token
     */
    public function __construct($application, $token)
    {
        $this->application = $application;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Новое сообщение в заявке')
                    ->markdown('mail.user.message');
    }
}
