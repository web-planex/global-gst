<?php

namespace App\Mail\Globals;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    public $verifyUrl;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url,$user)
    {
        $this->verifyUrl = $url;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mymail@gmail.com';
        $name = 'Name';
        $subject = 'Verify Email Address';
        return $this->to($this->user)->subject($subject)->from($address, $name)->
        markdown('emails.verify-email',['url' => $this->verifyUrl,'user' => $this->user]);
    }
}
