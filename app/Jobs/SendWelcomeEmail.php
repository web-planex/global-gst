<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Globals\SignUpMail;
use Illuminate\Support\Facades\Mail;
use App\User;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $uid;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::findOrFail($this->uid);
        $company_logo = url('assets/images/logo_2.png');
        $customer_name = ucwords($user['name']);
        $data = ['company_logo' => $company_logo,'customer_name' => $customer_name];
        Mail::to($user['email'])->send(new SignUpMail($data));
    }
}
