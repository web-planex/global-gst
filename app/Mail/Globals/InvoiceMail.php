<?php

namespace App\Mail\Globals;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
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
        $this->invoice_number = $request['invoice_number'];
        $this->order_number = $request['order_number'];
        $this->customer_name = $request['customer_name'];
        $this->company_logo = $request['company_logo'];
        $this->email_content = $request['email_content'];
        $this->invoice_id = $request['invoice_id'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject =   'Copy of invoice '.$this->invoice_number;
        $from_email = env('MAIL_FROM_ADDRESS');
        $from_name  = env('MAIL_FROM_NAME');
        $this->email_content  = str_replace( 'CustomerName', $this->customer_name, $this->email_content);
        $this->email_content  = str_replace( 'InvoiceNumber', $this->invoice_number, $this->email_content);
        return $this->view('globals.emails.invoice')->with([
            'company_name' =>  $this->company_name,
            'company_logo' =>  $this->company_logo,
            'email_content' =>  $this->email_content,
            'invoice_id' => $this->invoice_id
        ])->from($from_email, $from_name)->subject($subject);
    }
}
