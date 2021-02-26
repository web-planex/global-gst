<?php

namespace App\Mail\Globals;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignUpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->company_logo = $request['company_logo'];
        $this->customer_name = $request['customer_name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        $subject =   'Welcome to GST Invoices by WebPlanex';
//        $from_email = env('MAIL_FROM_ADDRESS');
//        $from_name  = env('MAIL_FROM_NAME');
//
//        return $this->view('globals.emails.sign-up')->with([
//            'company_logo' =>  $this->company_logo,
//            'customer_name' =>  $this->customer_name,
//        ])->from($from_email, $from_name)->subject($subject);

        return $this->view('globals.emails.sign-up')->with([
            'company_logo' =>  $this->company_logo,
            'customer_name' =>  $this->customer_name,
        ]);
    }
}
