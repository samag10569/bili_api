<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\RegisterRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\ContactsList;
use App\Models\Degree;
use App\Models\EmailExcel;
use App\Models\Skills;
use App\Models\State;
use App\Models\UserInfo;
use App\User;
use Classes\UploadImg;
use Classes\UserCheck;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    public function getStep1($reagent_id = null, $reagent_email = null)
    {
        if (Auth::check() and Auth::user()->member) {
            return Redirect::action('Crm\HomeController@getIndex');
        } else {
            if ($reagent_id != null and $reagent_email != null) {
                if (ContactsList::whereId($reagent_id)->whereEmail($reagent_email)->exists()) {
                    Session::put('reagent_email', $reagent_email);
                    Session::put('reagent_id', $reagent_id);
                    Session::put('type', 'introduction');
                } elseif (EmailExcel::whereId($reagent_id)->whereEmail($reagent_email)->exists()) {
                    Session::put('reagent_email', $reagent_email);
                    Session::put('reagent_id', $reagent_id);
                    Session::put('type', 'excel');
                } else {
                    Session::forget('reagent_email');
                    Session::forget('reagent_id');
                    Session::forget('type');
                    abort(404);
                }
            } else {
                Session::forget('reagent_email');
                Session::forget('reagent_id');
                Session::forget('type');
            }
            return view('site.register.step1');
        }
    }

    public function postStep1(RegisterRequest $request)
    {
        $checker = new UserCheck();
        $input = $request->all();

//        if ($request->has('date_interview') and $request->get('interview_type_id') == 1) {
//            $date_interview = explode('/', $input['date_interview']);
//            $input['date_interview'] = jmktime(0, 0, 0, $date_interview[1], $date_interview[0], $date_interview[2]);
//            $input['for_check'] = jmktime(0, 0, 0, $date_interview[1], $date_interview[0], $date_interview[2]);
//            $date_check = $checker->check_capacity($input['for_check']);
//            if (!$date_check) {
//                return Redirect::back()
//                    ->with('error', 'ظرفیت تاریخ انتخابی تکمیل است، تاریخ دیگری را برای مصاحبه انتخاب کنید.')
//                    ->withinput();
//            }
//        } else {
//            $input['date_interview'] = time();
//        }

        $input['date_interview'] = time();
        $input['interview_type_id'] = 0;

        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/user/');
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }

        $input['password'] = bcrypt($input['password']);
        $input['rejection'] = 0;
        $input['member'] = 1;
        $input['register_id'] = '-1';
        $input['status_id'] = 1;
        $input['step'] = 'Step2';
        $gmail = $checker->checkGmail($request->email);
        $user = User::create($input);
        $input['user_id'] = $user->id;
        User::where('id', $input['user_id'])->update(['user_code' => $checker->user_code($input['user_id'])]);

        $input['score'] = 0;
        $input['score_id'] = Degree::where('min', '<=', $input['score'])
            ->where('max', '>', $input['score'])
            ->firstorfail()->title;

        UserInfo::create($input);

        $checker->emailConfirm($input['user_id']);
        $checker->smsConfirm($input['user_id']);

        if ($gmail) {
            return Socialite::driver('google')->scopes(['https://www.google.com/m8/feeds/'])->redirect();
        } else {
            Auth::loginUsingId($input['user_id']);
            return Redirect::action('Site\RegisterController@getStep2');
        }
    }

    public function getStep2()
    {
        if (Auth::check() and Auth::user()->step == 'Step2') {

            if (Session::has('reagent_email') and Session::has('reagent_id') and Session::has('type')) {

                if (Session::get('type') == 'excel') {
                    EmailExcel::whereId(Session::get('reagent_id'))->update(['status' => 1]);
                    $user_id = EmailExcel::whereId(Session::get('reagent_id'))->first()->user_id;
                } elseif (Session::get('type') == 'introduction') {
                    ContactsList::whereId(Session::get('reagent_id'))->update(['status' => 1]);
                    $user_id = ContactsList::whereId(Session::get('reagent_id'))->first()->user_id;
                }

                $user = Auth::user();
                $recipient = User::find($user_id);
                if ($recipient)
                    $user->befriend($recipient);
            }

            $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
            $state_id = ['' => 'انتخاب کنید . . .'] + $state_id;

            return view('site.register.step2')
                ->with('state_id', $state_id);
        } else {
            abort(404);
        }
    }

    public function postStep2(RegisterRequest $request)
    {
        $input = Input::except(['_token']);
        $user_id = Auth::id();
        User::where('id', $user_id)->update(['step' => 'Step3']);
        UserInfo::where('user_id', $user_id)->update($input);

        return Redirect::action('Site\RegisterController@getStep3');
    }

    public function getStep3()
    {
        if (Auth::check() and Auth::user()->step == 'Step3') {
            $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
            $branch_id = ['' => 'انتخاب کنید . . .'] + $branch_id;

            $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
            $category_id = ['' => 'انتخاب کنید . . .'] + $category_id;

            $skills = Skills::Orderby('title', 'ASC')->select(['title', 'id'])->get();
            $skillId = [];

            return view('site.register.step3')
                ->with('skills', $skills)
                ->with('skillId', $skillId)
                ->with('branch_id', $branch_id)
                ->with('category_id', $category_id);
        } else {
            abort(404);
        }
    }

    public function postStep3(RegisterRequest $request)
    {
        $input = Input::except(['_token', 'mobile_confirm_code', 'email_confirm_code']);

        if ($request->has('birth')) {
            $birth = explode('/', $input['birth']);
            if (count($birth) > 1)
                $input['birth'] = jmktime(0, 0, 0, $birth[1], $birth[0], $birth[2]);
            else
                $input['birth'] = null;
        } else {
            $input['birth'] = null;
        }

        $input['article'] = $request->has('article');
        $input['expertise'] = $request->has('expertise');
        $input['ideas'] = $request->has('ideas');
        $input['invention'] = $request->has('invention');

        $user_id = Auth::id();
        $inputUser = [
            'category_id' => $input['category_id'],
            'branch_id' => $input['branch_id'],
            'profile_complete' => 1,
            'step' => null,
        ];
        $user = User::where('id', $user_id)->first();
        $user->update($inputUser);

        if ($request->has('skills')) {
            $user->assignSkill($request['skills']);
        }

        unset($input['category_id']);
        unset($input['branch_id']);
        unset($input['skills']);
        UserInfo::where('user_id', $user_id)->update($input);

        return Redirect::action('Auth\LoginController@getCrmLogin');
    }

    public function postConfirm(RegisterRequest $request)
    {
        $data['status'] = 'no';
        $data['type'] = $request->get('type');
        $user = User::find(Auth::id());
        if ($request->get('type') == 'email') {
            if (!$user->email_confirm) {
                if ($user->email_confirm_code == $request->get('confirm_code')) {
                    $user->update(['email_confirm' => 1]);
                    $data['status'] = 'ok';
                }
            }
        } else {
            if (!$user->phone_confirm) {
                if ($user->phone_confirm_code == $request->get('confirm_code')) {
                    $user->update(['phone_confirm' => 1]);
                    $data['status'] = 'ok';
                }
            }
        }
        return json_encode($data);
    }
}
