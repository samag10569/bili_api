<?php

namespace App\Jobs;

use App\Models\EmailSend;
use App\Models\EmailSendUser;
use Classes\UserCheck;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailSendJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $emailId;

    public function __construct($emailId)
    {
        ini_set('max_execution_time', 500);
        $this->emailId = $emailId;
    }

    public function handle()
    {
        $checker = new UserCheck();
        $emailSend = EmailSend::find($this->emailId);
        $emailSendData = [
            'sender' => $emailSend->sender,
            'subject' => $emailSend->subject,
        ];
        $emailUser = EmailSendUser::whereEmailSendId($emailSend->id)
            ->whereStatus(0)
            ->with('user')
            ->take($emailSend->count)
            ->get();

        foreach ($emailUser as $item) {
            if ($item->type == "email") {
                $checker->emailUserQueue($item->id, $emailSendData);
            } elseif ($item->type == "introduction") {
                $checker->emailContactQueue($item->id, $emailSendData);
            } elseif ($item->type == "excel") {
                $checker->emailExcelQueue($item->id, $emailSendData);
            }
        }
    }
}
