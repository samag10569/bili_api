<?php

namespace Classes;

use App\Models\Allotment;
use App\Models\AllotmentMessage;
use App\Models\AllotmentOption;
use App\Models\AllotmentUser;
use App\Models\Capacity;
use App\Models\ContactsList;
use App\Models\Degree;
use App\Models\EmailExcel;
use App\Models\EmailSend;
use App\Models\EmailSendUser;
use App\Models\IgnoreEmail;
use App\Models\ProjectRequired;
use App\Models\Setting;
use App\Models\UserContent;
use App\Models\UserInfo;
use App\Models\UserStatusDate;
use App\User;
use Exception;
use Hootlex\Friendships\Models\Friendship;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use mPDF;

require_once "pdf/mpdf.php";

class UserCheck
{
    public function check_capacity($date)
    {
        $capacity = Capacity::where('date', $date)->first();
        if ($capacity) {
            if ($capacity->capacity > 0) {
                $capacity->capacity--;
                $capacity->save();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function user_code($user_id)
    {
        $user = User::find($user_id);
        $month = jdate('m', $user->created_at->timestamp, '', '', 'en');
        $year = jdate('Y', $user->created_at->timestamp, '', '', 'en');
        $user_code = $user_id . '/' . $month . '/' . $year;
        return $user_code;
    }

    public function invitationPdf(User $user)
    {
        $html = view('admin.pending.pdf')
            ->with('user', $user)
            ->render();

        //$pathToFile = public_path() . '/assets/uploads/invitation/';
        $pathToFile = '/home/mostafa/domains/ejavan.net/public/assets/uploads/invitation/';
        $mpdf = new mPDF('ar');
        $mpdf->SetDirectionality('rtl');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pathToFile . $user->id . ".pdf");
        if ($mpdf)
            return true;
        return false;
    }

    public function sendEmail(User $user)
    {
        ini_set('max_execution_time', 500);
        //$pathToFile = public_path('assets/uploads/invitation/' . $user->id . '.pdf');
        $pathToFile = '/home/mostafa/domains/ejavan.net/public/assets/uploads/invitation/' . $user->id . '.pdf';
        $sender = Setting::first()->sender;
        try {
            Mail::send('admin.pending.email', ['user' => $user], function ($m) use ($user, $pathToFile, $sender) {
                $m->from($sender, 'Register ejavan Form')
                    ->attach($pathToFile)
                    ->to($user->email, $user->name . ' ' . $user->family)
                    ->subject('دعوت نامه شبکه رشد علم جوان');
            });
            File::delete($pathToFile);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getInvitationEmail($user_id)
    {
        $user = User::find($user_id);
        $data['status'] = 'no';
        $data['msg'] = 'مشکل در ارسال ایمیل، مجدد تلاش کنید.';

        $invitation = $this->invitationPdf($user);

        if ($invitation) {
            $email = $this->sendEmail($user);
            if ($email) {
                $data['status'] = 'ok';
                $data['msg'] = 'ایمیل ارسال شد.';
                return $data;
            } else {
                return $data;
            }
        } else {
            return $data;
        }
    }

    public function gradeScore($input)
    {
        $score = 0;

        if (isset($input['education'])) $score += $input['education'];
        if (isset($input['prizes'])) $score += $input['prizes'];
        if (isset($input['membership'])) $score += $input['membership'];
        if (isset($input['writing'])) $score += $input['writing'];
        if (isset($input['activity'])) $score += $input['activity'];
        if (isset($input['education_courses'])) $score += $input['education_courses'];
        if (isset($input['research_projects'])) $score += $input['research_projects'];
        if (isset($input['services_caribbean'])) $score += $input['services_caribbean'];

        if (isset($input['project_required1'])) $score += $input['project_required1'];
        if (isset($input['project_required2'])) $score += $input['project_required2'];
        if (isset($input['project_required3'])) $score += $input['project_required3'];
        if (isset($input['project_required4'])) $score += $input['project_required4'];
        if (isset($input['project_required5'])) $score += $input['project_required5'];

        if (isset($input['invention1'])) $score += $input['invention1'];
        if (isset($input['invention2'])) $score += $input['invention2'];
        if (isset($input['invention3'])) $score += $input['invention3'];
        if (isset($input['invention4'])) $score += $input['invention4'];
        if (isset($input['invention5'])) $score += $input['invention5'];

        if (isset($input['use_of_services1'])) $score += $input['use_of_services1'];
        if (isset($input['use_of_services2'])) $score += $input['use_of_services2'];
        if (isset($input['use_of_services3'])) $score += $input['use_of_services3'];
        if (isset($input['use_of_services4'])) $score += $input['use_of_services4'];
        if (isset($input['use_of_services5'])) $score += $input['use_of_services5'];

        return $score;
    }

    public function getCaller($user_id)
    {
        $user = User::find($user_id);
        $user->phone_call++;
        $user->save();
        $data['phone_call'] = $user->phone_call;
        $data['id'] = $user_id;
        return $data;
    }

    public function getCallerWing($user_id)
    {
        $user = User::find($user_id);
        $user->phone_wing++;
        $user->save();
        $data['phone_wing'] = $user->phone_wing;
        $data['id'] = $user_id;
        return $data;
    }

    public function getDeleteContent($content_id)
    {
        $content = UserContent::find($content_id);
        $data['status'] = 'no';
        $data['msg'] = 'مشکل در حذف اطلاعات، لطفا مجدد تلاش نمایید.';

        if ($content->delete()) {
            $data['status'] = 'ok';
            $data['msg'] = 'اطلاعات با موفقیت حذف شد.';
        }
        return $data;
    }

    public function getDeleteOption($option_id)
    {
        $option = AllotmentOption::find($option_id);
        $data['status'] = 'no';
        $data['msg'] = 'مشکل در حذف اطلاعات، لطفا مجدد تلاش نمایید.';

        if ($option->delete()) {
            $data['status'] = 'ok';
            $data['msg'] = 'اطلاعات با موفقیت حذف شد.';
        }
        return $data;
    }

    public function getDeleteMessage($message_id)
    {
        $message = AllotmentMessage::find($message_id);
        $data['status'] = 'no';
        $data['msg'] = 'مشکل در حذف اطلاعات، لطفا مجدد تلاش نمایید.';

        if ($message->delete()) {
            $data['status'] = 'ok';
            $data['msg'] = 'اطلاعات با موفقیت حذف شد.';
        }
        return $data;
    }

    public function projectPdf(ProjectRequired $data)
    {
        $html = view('admin.project-required.pdf')
            ->with('data', $data)
            ->render();

        $mpdf = new mPDF('ar');
        $mpdf->SetDirectionality('rtl');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        if ($mpdf)
            return true;
        return false;
    }

    public function statusDate($user_id, $status_id)
    {
        $staus = UserStatusDate::whereUserId($user_id)->pluck('status_id')->all();
        if (!$staus) {
            $input = [
                'user_id' => $user_id,
                'status_id' => $status_id,
            ];
            UserStatusDate::create($input);
        } else {
            $max = max($staus);
            if ($status_id > $max) {
                $input = [
                    'user_id' => $user_id,
                    'status_id' => $status_id,
                ];
                UserStatusDate::updateOrCreate($input);
            } else {
                $del_status = UserStatusDate::whereUserId($user_id)
                    ->where('status_id', '>', $status_id)
                    ->get();
                foreach ($del_status as $del_statu) {
                    $del_statu->delete();
                }
                $input = [
                    'user_id' => $user_id,
                    'status_id' => $status_id,
                ];
                UserStatusDate::updateOrCreate($input);
            }
        }
    }

    public function importContacts($token, $user_id)
    {
        $max_results = 200;
        $accesstoken = $token;
        $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_results . '&alt=json&v=3.0&oauth_token=' . $accesstoken;
        $xmlresponse = Helper::curl($url);
        $contacts = json_decode($xmlresponse, true);
        if (!empty($contacts['feed']['entry'])) {
            foreach ($contacts['feed']['entry'] as $contact) {
                if (isset($contact['gd$email'])) {
                    if (!ContactsList::whereEmail($contact['gd$email'][0]['address'])->exists()) {
                        $input = [
                            'user_id' => $user_id,
                            'name' => $contact['title']['$t'],
                            'email' => $contact['gd$email'][0]['address'],
                        ];
                        ContactsList::create($input);
                    }
                }
            }
            User::whereId($user_id)->update(['import_contacts' => 1]);
        }
        return true;
    }

    public function checkGmail($email)
    {
        $arrayEmail = explode('@', $email);
        if (isset($arrayEmail[1])) {
            $arrayGmail = explode('gmail', $arrayEmail[1]);
            if (isset($arrayGmail[1]) and $arrayGmail[1] == '.com')
                return true;
            else
                return false;
        } else {
            return false;
        }
    }

    public function emailConfirm($user_id)
    {
        $user = User::find($user_id);
        $confirm_code = str_random(32);
        $user->update([
            'email_confirm_code' => $confirm_code
        ]);

        ini_set('max_execution_time', 500);
        $sender = Setting::first()->sender;
        try {
            Mail::send('admin.emails.verify', ['user' => $user], function ($message) use ($user, $sender) {
                $message->from($sender, 'Register ejavan Form')
                    ->to($user->email, $user->name . ' ' . $user->family)
                    ->subject('لینک تاییدیه ایمیل – شبکه رشد علم جوان');
            });

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function smsConfirm($user_id)
    {
        $user = User::find($user_id);
        $confirm_code = random_int(100000, 999999);
        $user->update([
            'phone_confirm_code' => $confirm_code
        ]);
        $msg = 'کاربر گرامی کد تایید شما ' . $confirm_code . ' می باشد. ';

        try {
            //TODO: Send SMS msg
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public static function checkAllotment($user_id, $allotment_id)
    {
        $resualt = AllotmentUser::whereUserId($user_id)
            ->whereAllotmentId($allotment_id)
            ->first();
        if (!$resualt) {
            return false;
        } else {
            return $resualt->status;
        }
    }

    public static function checkAllotmentAll($user_id)
    {
        $resualt = AllotmentUser::whereUserId($user_id)
            ->count();
        return $resualt;
    }

    public static function checkFriend($sender, $user_id)
    {
        $friend = Friendship::whereSenderId($sender)
            ->whereRecipientId($user_id)
            ->first();
        if ($friend)
            return $friend->status;
        return (-1);
    }

    public static function upMemberShipType($user_id)
    {
        $userInfo = UserInfo::whereUserId($user_id)->first(['membership_type_id']);
        if (!$userInfo) abort(404);
        if ($userInfo->membership_type_id > 2) {
            $membershipType_time = $userInfo->membershipType->time;
            $old = $userInfo->date_membership_type;
            $today = time();
            $diff = ($today - $old) / 86400;
            if ($diff > $membershipType_time) {
                UserInfo::whereUserId($user_id)
                    ->update([
                        'status_membership_type' => 0,
                    ]);
            }
        }
        return true;
    }

    public function emailUserQueue($id, $emailSend)
    {
        $emailUser = EmailSendUser::whereId($id)
            ->whereStatus(0)
            ->with('user')
            ->first();

        $token = substr(md5(rand()), 0, 32);
        $arrayEmail = explode('@', $emailSend['sender']);

        if (isset($arrayEmail[0]) and isset($arrayEmail[1])) {
            $emailSend['sender'] = $arrayEmail[0] . '+' . $token . '@' . $arrayEmail[1];
        }

        try {
            Mail::queue('admin.email-send.email', ['user' => $emailUser->user, 'email_send' => $emailSend], function ($m) use ($emailUser, $emailSend) {
                $m->from($emailSend['sender'], 'Register ejavan Form')
                    ->to($emailUser->user->email, jdate('Y/m/d H:i') . ' ' . $emailUser->user->name . ' ' . $emailUser->user->family)
                    ->subject($emailSend['subject']);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        EmailSendUser::whereUserId($emailUser->user_id)->update(['status' => 1]);

    }

    public function emailContactQueue($id, $emailSend, $test = false)
    {


        if ($test) {
            $setting = Setting::first();
            $contactTest = ContactsList::first();

            $token = substr(md5(rand()), 0, 32);
            $arrayEmail = explode('@', $setting->sender);

            if (isset($arrayEmail[0]) and isset($arrayEmail[1])) {
                $setting->sender = $arrayEmail[0] . '+' . $token . '@' . $arrayEmail[1];
            }

            Mail::queue('admin.contacts-list.email', ['reagent' => $contactTest, 'test' => $test], function ($m) use ($setting) {
                $m->from($setting->sender, 'Register ejavan Form')
                    ->to(config('options.email'), jdate('Y/m/d H:i') . ' معرفی نامه تست ')
                    ->subject('معرفی نامه تست');
            });
        } else {
            $emailUser = EmailSendUser::whereId($id)
                ->whereStatus(0)
                ->with('contactsList')
                ->first();

            $token = substr(md5(rand()), 0, 32);
            $arrayEmail = explode('@', $emailSend['sender']);

            if (isset($arrayEmail[0]) and isset($arrayEmail[1])) {
                $emailSend['sender'] = $arrayEmail[0] . '+' . $token . '@' . $arrayEmail[1];
            }

            if (!$this->checkIgnoreEmail($emailUser->contactsList->email, 'introduction', $emailUser->contactsList->id)) {
                try {
                    Mail::queue('admin.contacts-list.email', ['reagent' => $emailUser->contactsList, 'test' => $test], function ($m) use ($emailUser, $emailSend) {
                        $m->from($emailSend['sender'], 'Register ejavan Form')
                            ->to($emailUser->contactsList->email, jdate('Y/m/d H:i') . ' ' . $emailUser->contactsList->name)
                            ->subject($emailSend['subject']);
                    });
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            }

            EmailSendUser::whereUserId($emailUser->user_id)->update(['status' => 1]);
            ContactsList::whereId($emailUser->contactsList->id)->update(['send_email' => 1]);
        }
    }


    public function emailIntroduction($id)
    {
        $reagent = ContactsList::find($id);
        $test = false;
        if ($reagent) {
            if (!$this->checkIgnoreEmail($reagent->email, 'introduction', $reagent->id)) {
                try {
                    Mail::queue('admin.contacts-list.email', ['reagent' => $reagent, 'test' => $test], function ($m) use ($reagent) {
                        $m->to($reagent->email, jdate('Y/m/d H:i') . ' ' . $reagent->name)
                            ->subject('دعوت نام شبکه رشد علم جوان');
                    });
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        }

        ContactsList::whereId($id)->update(['send_email' => 1, 'status' => 1]);
    }

    public function emailExcelQueue($id, $emailSend)
    {
        $emailUser = EmailSendUser::whereId($id)
            ->whereStatus(0)
            ->with('emailExcel')
            ->first();

        $token = substr(md5(rand()), 0, 32);
        $arrayEmail = explode('@', $emailSend['sender']);

        if (isset($arrayEmail[0]) and isset($arrayEmail[1])) {
            $emailSend['sender'] = $arrayEmail[0] . '+' . $token . '@' . $arrayEmail[1];
        }

        $test = false;
        if (!$this->checkIgnoreEmail($emailUser->emailExcel->email, 'excel', $emailUser->emailExcel->id)) {
            try {
                Mail::queue('admin.email-excel.email', ['reagent' => $emailUser->emailExcel, 'test' => $test], function ($m) use ($emailUser, $emailSend) {
                    $m->from($emailSend['sender'], 'Register ejavan Form')
                        ->to($emailUser->emailExcel->email, jdate('Y/m/d H:i') . ' ' . $emailUser->emailExcel->name)
                        ->subject($emailSend['subject']);
                });
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }


        EmailSendUser::whereUserId($emailUser->user_id)->update(['status' => 1]);
        EmailExcel::whereId($emailUser->emailExcel->id)->update(['send_email' => 1]);

    }


    public function checkIgnoreEmail($email, $type, $type_id)
    {
        return IgnoreEmail::whereEmail($email)
            ->whereType($type)
            ->whereTypeId($type_id)
            ->exists();
    }

    public function scoreUserAllotment($allotment_id, $user_id)
    {
        $score_a = Allotment::find($allotment_id)->score;
        $userInfo = UserInfo::whereUserId($user_id)->first();

        $allotment_score = $score_a + $userInfo->allotment_score;
        $score = $allotment_score + $userInfo->grade_score;

        $score_id = Degree::where('min', '<=', $score)
            ->where('max', '>', $score)
            ->firstorfail()->title;

        $allotment = Degree::where('min', '<=', $allotment_score)
            ->where('max', '>', $allotment_score)
            ->firstorfail()->title;

        UserInfo::whereId($userInfo->id)->update([
            'score' => $score,
            'score_id' => $score_id,
            'allotment_score' => $allotment_score,
            'allotment' => $allotment
        ]);

        return true;
    }

    public function scoreUserGrade($user_id)
    {
        $userInfo = UserInfo::whereUserId($user_id)->first();

        $score = $userInfo->allotment_score + $userInfo->grade_score;

        $score_id = Degree::where('min', '<=', $score)
            ->where('max', '>', $score)
            ->firstorfail()->title;

        UserInfo::whereId($userInfo->id)->update([
            'score' => $score,
            'score_id' => $score_id
        ]);

        return true;
    }
}