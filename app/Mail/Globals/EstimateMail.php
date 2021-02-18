<?php

namespace App\Mail\Globals;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstimateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->company_name = $request['company_name'];
        $this->from_name = $request['from_name'];
        $this->from_email = $request['from_email'];
        $this->customer_email = $request['customer_email'];
        $this->estimate_number = $request['estimate_number'];
        $this->customer_name = $request['customer_name'];
        $this->company_logo = $request['company_logo'];
        $this->email_content = $request['email_content'];
        $this->estimate_id = $request['estimate_id'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject =   'Copy of estimate '.$this->estimate_number;
        $from_email = 'info@webplanex.com';
        $from_name  = $this->from_email;
        $this->email_content  = str_replace( 'CustomerName', $this->customer_name, $this->email_content);
        $this->email_content  = str_replace( 'EstimateNumber', $this->estimate_number, $this->email_content);
        return $this->view('globals.emails.estimate')->with([
            'company_name' =>  $this->company_name,
            'company_logo' =>  $this->company_logo,
            'email_content' =>  $this->email_content,
            'estimate_id' => $this->estimate_id
        ])->from($from_email, $from_name)->subject($subject);
    }
}
