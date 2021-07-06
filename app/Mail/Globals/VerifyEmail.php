<?php

namespace App\Mail\Globals;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
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
        $this->url_token = $request['token'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject =   'Verify Email Address';
        $from_email = env('MAIL_FROM_ADDRESS');
        $from_name  = 'GST Invoices By WebPlanex';

        return $this->view('globals.emails.verify-email')->with([
            'company_logo' =>  $this->company_logo,
            'customer_name' =>  $this->customer_name,
            'token' =>  $this->url_token,
        ])->from($from_email, $from_name)->subject($subject);
    }
}
