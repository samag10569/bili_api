<?php

namespace App\Console\Commands;

use App\Jobs\EmailSendJob;
use App\Models\EmailSend;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EmailSendCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check email for send';

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
     * @return mixed
     */
    public function handle()
    {
        Log::info('Run cmd '.time());
        $email_send = EmailSend::whereStatus(0)->with('emailUserFaild')->get();
        foreach ($email_send as $item) {
            if (count($item->emailUserFaild)) {
                dispatch(new EmailSendJob($item->id));
            } else {
                EmailSend::whereId($item->id)->update(['status' => 1]);
            }
        }
    }
}
