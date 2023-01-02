<?php

namespace App\Console\Commands;

use App\Jobs\SmsSendJob;
use App\Models\SmsSend;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SmsSendCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check sms for send';

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
        $sms_send = SmsSend::whereStatus(0)->with('smsUserFaild')->get();
        foreach ($sms_send as $item) {
            if (count($item->smsUserFaild)) {
                dispatch(new SmsSendJob($item->id));
            } else {
                SmsSend::whereId($item->id)->update(['status' => 1]);
            }
        }
    }
}
