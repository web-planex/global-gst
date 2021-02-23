<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendWelcomeEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron for send welcome email after 1 hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Welcome email Cron run at:'.date('d-m-Y H:i:s'));
        if (file_exists(__DIR__ . '/send_welcome_email.pid')) {
            $pid = file_get_contents(__DIR__ . '/send_welcome_email.pid');
            $result = exec('ps | grep ' . $pid);
            if ($result == '') {
                $this->SendEmail();
            }
        } else {
            $this->SendEmail();
        }
    }
    
    public function SendEmail() {
        mail('lalitv@webplanex.com', 'GST Send Welcome Email Queue Start', "Successfully");
        $command = '/usr/bin/php7.3 /home/webplanexmain/gst.webplanex.com/artisan queue:work --queue=send_welcome_email --timeout=0 --tries=1 >> /dev/null 2>&1';
        $number = exec($command);
        file_put_contents(__DIR__ . '/send_welcome_email.pid', $number);
    }
}
