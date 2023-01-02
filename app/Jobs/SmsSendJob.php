<?php

namespace App\Jobs;

use App\Models\SmsSend;
use App\Models\SmsSendUser;
use Classes\UserCheck;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SmsSendJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $smsId;

    public function __construct($smsId)
    {
        ini_set('max_execution_time', 500);
        $this->smsId = $smsId;
    }

    public function handle()
    {
        $checker = new UserCheck();
        $smsSend = SmsSend::find($this->smsId);
        $smsSendData = [
            'sender' => $smsSend->sender,
            'subject' => $smsSend->subject,
        ];
        $smsUser = SmsSendUser::whereSmsSendId($smsSend->id)
            ->whereStatus(0)
            ->with('user')
            ->take($smsSend->count)
            ->get();

        foreach ($smsUser as $item) {
            if ($item->type == "sms") {
                $checker->smsUserQueue($item->id, $smsSendData);
            } elseif ($item->type == "introduction") {
                $checker->smsContactQueue($item->id, $smsSendData);
            } elseif ($item->type == "excel") {
                $checker->smsExcelQueue($item->id, $smsSendData);
            }
        }
    }
}
