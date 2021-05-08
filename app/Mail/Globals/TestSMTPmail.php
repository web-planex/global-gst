<?php

namespace App\Mail\Globals;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestSMTPmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->from_email = $request['from_email'];
        $this->from_name = $request['from_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            $subject = 'Your Test Configuration';
            return $this->from($this->from_email, $this->from_name)
                ->markdown('globals.emails.test_smtp_email_template')
                ->subject($subject);
            //code...
        } catch (\Exception $th) {
            mail("mukundh@webplanex.com", "TestMail Throwable", json_encode($th->getMessage()));
        }
    }
}
