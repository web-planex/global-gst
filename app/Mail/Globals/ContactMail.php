<?php

namespace App\Mail\Globals;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($request)
    {
        $this->company_logo = $request['company_logo'];
        $this->customer_name = $request['customer_name'];
        $this->from_mail = $request['from_mail'];
        $this->subject = $request['subject'];
        $this->message = $request['message'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject =   $this->subject;
        $from_email = $this->from_mail;
        $from_name  = $this->customer_name;
        return $this->view('globals.emails.contact-mail')->with([
            'company_logo' =>  $this->company_logo,
            'email_content' =>  $this->message,
            'subject' =>  $subject,
            'customer_name' =>  $from_name,
            'email' =>  $from_email,
        ])->from($from_email, $from_name)->subject($subject);
    }
}
