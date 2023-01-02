<?php

namespace App\Http\Controllers\Site;

use App\Jobs\EmailSendJob;
use App\Models\EmailSend;
use App\Models\OnlineUser;
use Classes\DateUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class JobRunController extends Controller
{
    public function getEmailSend()
    {
        $email_send = EmailSend::whereStatus(0)->with('emailUserFaild')->get();
        //Log::info('Run Job In Email' . time());
        foreach ($email_send as $item) {
            if (count($item->emailUserFaild)) {
                dispatch(new EmailSendJob($item->id));
            } else {
                EmailSend::whereId($item->id)->update(['status' => 1]);
            }
        }
    }

    public function getOnlineUser()
    {
        $time_check = time() - 300;
        OnlineUser::where('time_s', '<', $time_check)
            ->update(['status' => 0]);

        $date = new DateUtils();
        $old_day = $date->current_date(2);
        OnlineUser::where('date', '<', $old_day['start_date'])->delete();

    }
}
