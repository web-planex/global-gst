<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateExpenseZip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenerateExpenseZip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate expense voucher as single pdf or individual pdf format in a zip file.';

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
    public function handle() {
        Log::info('Cron run at:'.date('d-m-Y H:i:s'));
        if (file_exists(__DIR__ . '/multiple_expense_pdf.pid')) {
            $pid = file_get_contents(__DIR__ . '/multiple_expense_pdf.pid');
            $result = exec('ps | grep ' . $pid);
            if ($result == '') {
                $this->ExpensePdfQueue();
            }
        } else {
            $this->ExpensePdfQueue();
        }
    }
    
    function ExpensePdfQueue() {
        mail('lalitv@webplanex.com', 'Global GST DEMO multiple_expense_pdf Queue Start', "Successfully");
        $command = '/usr/bin/php7.3 /home/webplanexmain/gst.webplanex.com/artisan queue:work --queue=multiple_expense_pdf --timeout=0 --tries=1 >> /dev/null 2>&1';
        //$command = 'php artisan queue:work --queue=multiple_expense_pdf';
        $number = exec($command);
        file_put_contents(__DIR__ . '/multiple_expense_pdf.pid', $number);
    }
}
