<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\TempUsersRequest;
use App\User;
use Classes\UserCheck;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserRequest;
use App\Models\State;

class TempUsersController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = User::whereVerified(0);

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('start_interview') and $request->has('end_interview')) {
                $start = explode('/', $request->get('start_interview'));
                $end = explode('/', $request->get('end_interview'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('date_interview', array($s, $e));
            }
            if ($request->has('mobile')) {
                $query->where('mobile', 'LIKE', '%' . $request->get('mobile') . '%');
            }

        }


        $data = $query->paginate(15);


        return view('admin.tempusers.index')
            ->with('data',$data);
    }

    public function getIndex2(Request $request)
    {

        $query = User::whereIn('verified',[1,2]);

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('start_interview') and $request->has('end_interview')) {
                $start = explode('/', $request->get('start_interview'));
                $end = explode('/', $request->get('end_interview'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('date_interview', array($s, $e));
            }
            if ($request->has('name')) {
                $query->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }
            if ($request->has('family')) {
                $query->where('family', 'LIKE', '%' . $request->get('family') . '%');
            }
            if ($request->has('mobile')) {
                $query->where('mobile', 'LIKE', '%' . $request->get('mobile') . '%');
            }
            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('id', $request->get('id'));
            }
            if ($request->has('state_id')) {
                $query->join('user_info', 'users.id', '=', 'user_info.user_id')
                    ->where('user_info.state_id', $request->get('state_id'));
            }
            if ($request->get('sort') == 'date_interview') {
                $query->orderBy('users.date_interview', 'DESC');
            } else {
                $query->orderBy('users.id', 'DESC');
            }
        }

        if (!$request->has('sort')) {
            $query->orderBy('users.id', 'DESC');
        }

        $data = $query->Where(function ($query) {
            $query->orWhere('email_confirm', 0)->orWhere('phone_confirm', 0)
                ->orWhere('profile_complete', 0);
        })->paginate(15);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        return view('admin.search-member.resualt2')
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function postSendConfirmPhone(TempUsersRequest $request)
    {
        $dataRt['status'] = 'no';
        $dataRt['msg'] = 'لطفا مجدد تلاش نمایید.';

        $checker = new UserCheck();
        $resualt = $checker->smsConfirm($request->get('user'));

        if ($resualt) {
            $dataRt['status'] = 'ok';
            $dataRt['msg'] = 'با موفقیت ارسال شد.';
        }

        return response()->json($dataRt);
    }

    public function postSendConfirmEmail(TempUsersRequest $request)
    {
        $dataRt['status'] = 'no';
        $dataRt['msg'] = 'لطفا مجدد تلاش نمایید.';

        $user = User::find($request->get('user'));

        if ($user->email_confirm == 1)
            return response()->json(['status' => 0, 'error' => 'ایمیل کاربر قبلا تایید شده است.']);

        $checker = new UserCheck();
        $resualt = $checker->emailConfirm($request->get('user'));

        if ($resualt) {
            $dataRt['status'] = 'ok';
            $dataRt['msg'] = 'با موفقیت ارسال شد.';
        }

        return response()->json($dataRt);
    }

    public function getMobile($user_id)
    {
        $user = User::whereMember(1)
            ->where('phone_confirm', 0)
            ->whereId($user_id)
            ->first();
        if (!$user) abort(404);
        $user->update(['phone_confirm' => 1]);
        return Redirect::back()->with('success', 'شماره همراه کاربر مورد نظر با موفقیت تایید شد.');
    }

    public function getEmail($user_id)
    {
        $user = User::whereMember(1)
            ->where('email_confirm', 0)
            ->whereId($user_id)
            ->first();
        if (!$user) abort(404);
        $user->update(['email_confirm' => 1]);
        return Redirect::back()->with('success', 'ایمیل کاربر مورد نظر با موفقیت تایید شد.');
    }
}
