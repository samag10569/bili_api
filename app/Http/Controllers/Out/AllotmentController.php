<?php

namespace App\Http\Controllers\Out;

use App\Http\Requests\OutAllotmentRequest;
use App\Models\Allotment;
use App\Models\AllotmentMessage;
use App\Models\AllotmentUser;
use App\Models\State;
use App\Models\UserInfo;
use App\User;
use Classes\UserCheck;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AllotmentController extends Controller
{
    public function getAccepted(Request $request)
    {
        $allotment_id = explode('allotment', $request->segments()[1])[1];
        $query = AllotmentUser::query();
        $query->allotmentWithStatus(2, $allotment_id)
            ->join('users', 'allotment_user.user_id', '=', 'users.id');

        if ($request->has('search')) {

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
            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('users.id', $request->get('id'));
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

        $data = $query->select([
            'users.id as id',
            'users.id as user_id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            'users.admin_id as admin_id',
            'users.register_id as register_id',
            'users.mobile as mobile',
            'users.status_id as status_id',
            'users.email as email',
            'users.created_at as created_at',
            'users.date_interview as date_interview',
            'users.phone_wing as phone_wing',
        ])->paginate(20);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        $allotment = Allotment::find($allotment_id);
        return View('out.allotment.accepted')
            ->with('allotment', $allotment)
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getTotalWaiting(Request $request)
    {
        $allotment_id = explode('allotment', $request->segments()[1])[1];
        $query = AllotmentUser::query();
        $query->allotmentWithStatus(1, $allotment_id)
            ->join('users', 'allotment_user.user_id', '=', 'users.id');

        if ($request->has('search')) {

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
            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('users.id', $request->get('id'));
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

        $data = $query->select([
            'users.id as id',
            'users.id as user_id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            'users.admin_id as admin_id',
            'users.register_id as register_id',
            'users.mobile as mobile',
            'users.status_id as status_id',
            'users.email as email',
            'users.created_at as created_at',
            'users.date_interview as date_interview',
            'users.phone_wing as phone_wing',
        ])->paginate(20);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        $allotment = Allotment::find($allotment_id);
        return View('out.allotment.total-waiting')
            ->with('allotment', $allotment)
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getTotalRejected(Request $request)
    {
        $allotment_id = explode('allotment', $request->segments()[1])[1];

        $listAllotmentUser = AllotmentUser::whereAllotmentId($allotment_id)->pluck('user_id')->all();

        $query = User::query();
        $query->where('users.status_id', '>=', 4)
            ->whereNotIn('users.id', $listAllotmentUser);

        if ($request->has('search')) {

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
            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('users.id', $request->get('id'));
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

        $data = $query->select([
            'users.id as id',
            'users.id as user_id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            'users.admin_id as admin_id',
            'users.register_id as register_id',
            'users.mobile as mobile',
            'users.status_id as status_id',
            'users.email as email',
            'users.created_at as created_at',
            'users.date_interview as date_interview',
            'users.phone_wing as phone_wing',
        ])->paginate(20);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        $allotment = Allotment::find($allotment_id);
        return View('out.allotment.total-rejected')
            ->with('allotment', $allotment)
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getRejectedWings(Request $request)
    {
        $allotment_id = explode('allotment', $request->segments()[1])[1];
        $query = AllotmentUser::query();
        $query->allotmentWithStatus(5, $allotment_id)
            ->join('users', 'allotment_user.user_id', '=', 'users.id');

        if ($request->has('search')) {

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
            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('users.id', $request->get('id'));
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

        $data = $query->select([
            'users.id as id',
            'users.id as user_id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            'users.admin_id as admin_id',
            'users.register_id as register_id',
            'users.mobile as mobile',
            'users.status_id as status_id',
            'users.email as email',
            'users.created_at as created_at',
            'users.date_interview as date_interview',
            'users.phone_wing as phone_wing',
        ])->paginate(20);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        $allotment = Allotment::find($allotment_id);
        return View('out.allotment.rejected-wings')
            ->with('allotment', $allotment)
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getWaitingWings(Request $request)
    {
        $allotment_id = explode('allotment', $request->segments()[1])[1];
        $query = AllotmentUser::query();
        $query->allotmentWithStatus(4, $allotment_id)
            ->join('users', 'allotment_user.user_id', '=', 'users.id');

        if ($request->has('search')) {

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
            if ($request->has('email')) {
                $query->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }
            if ($request->has('user_code')) {
                $query->where('user_code', $request->get('user_code'));
            }
            if ($request->has('id')) {
                $query->where('users.id', $request->get('id'));
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

        $data = $query->select([
            'users.id as id',
            'users.id as user_id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            'users.admin_id as admin_id',
            'users.register_id as register_id',
            'users.mobile as mobile',
            'users.status_id as status_id',
            'users.email as email',
            'users.created_at as created_at',
            'users.date_interview as date_interview',
            'users.phone_wing as phone_wing',
        ])->paginate(20);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        $allotment = Allotment::find($allotment_id);
        return View('out.allotment.waiting-wings')
            ->with('allotment', $allotment)
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getCaller($user_id)
    {
        $checker = new UserCheck();
        $data = $checker->getCallerWing($user_id);
        return json_encode($data);
    }

    public function getEdit($user_id, Request $request)
    {
        $allotment_id = explode('allotment', $request->segments()[1])[1];
        $allotment_user = AllotmentUser::whereUserId($user_id)
            ->whereAllotmentId($allotment_id)
            ->first();
        if ($allotment_user) {
            $allotment_data_status = $allotment_user->status;
        } else {
            $allotment_data_status = 0;
            $allotment_user = [];
        }

        $allotment_title = Allotment::find($allotment_id)->title;

        switch ($allotment_data_status) {
            case 0:
                $accsess = 'totalRejected';
                break;
            case 1:
                $accsess = 'totalWaiting';
                break;
            case 2:
                $accsess = 'accepted';
                break;
            case 4:
                $accsess = 'waitingWings';
                break;
            case 5:
                $accsess = 'rejectedWings';
                break;
        }

        if (Auth::user()->hasPermission('allotment' . $allotment_id . '.' . $accsess)) {
            $data = User::userSearch()
                ->find($user_id);
            if (!$data) abort(404);

            $info_data = UserInfo::whereUserId($user_id)->first();
            $message = AllotmentMessage::whereUserId($user_id)
                ->whereAllotmentId($allotment_id)
                ->first();
            if (!$message)
                $message = [];

            if ($allotment_data_status == 4 || $allotment_data_status == 5 || $allotment_data_status == 2) {
                $allotment_status = [
                    '5' => 'رد شده بال خدماتی',
                    '2' => 'تایید شده',
                    '4' => 'در انتظار بال خدماتی',
                ];
            } else {
                $allotment_status = [
                    '0' => 'رد شده',
                    '2' => 'تایید شده',
                    '1' => 'در انتظار',
                ];
            }
            return View('out.allotment.edit')
                ->with('allotment_status', $allotment_status)
                ->with('allotment_user', $allotment_user)
                ->with('info_data', $info_data)
                ->with('allotment_id', $allotment_id)
                ->with('allotment_data_status', $allotment_data_status)
                ->with('message', $message)
                ->with('allotment_title', $allotment_title)
                ->with('data', $data);
        } else {
            return redirect('/out')->with('error', 'شما به این بخش دسترسی ندارید.');
        }

    }

    public function postEdit($user_id, OutAllotmentRequest $request)
    {
        $allotment_id = explode('allotment', $request->segments()[1])[1];
        $input = $request->all();

        $check = AllotmentUser::whereUserId($user_id)->whereAllotmentId($allotment_id);
        if ($check->exists()) {
            $back_status = $check->first()->status;
        } else {
            $back_status = 0;
        }
        switch ($back_status) {
            case 0:
                $back = 'total.rejected';
                break;
            case 1:
                $back = 'total.waiting';
                break;
            case 2:
                $back = 'accepted';
                break;
            case 4:
                $back = 'waiting.wings';
                break;
            case 5:
                $back = 'rejected.wings';
                break;
        }
        if ($input['allotment_status'] == 0) {
            if ($check->exists()) {
                AllotmentUser::whereUserId($user_id)
                    ->whereAllotmentId($allotment_id)
                    ->delete();
            }
        } else {
            if ($check->exists()) {
                $input_update['status'] = $input['allotment_status'];
                if ($input['allotment_status'] == 2) {
                    $checker = new UserCheck();
                    $checker->scoreUserAllotment($allotment_id, $user_id);
                    $input_update['date_confirm'] = time();
                }
                if ($request->has('inspector_amount')) {
                    $input_update['inspector_amount'] = $input['inspector_amount'];
                }
                $check->update($input_update);

            } else {
                if ($input['allotment_status'] != 0) {
                    $input_create = [
                        'admin_id' => Auth::user()->id,
                        'user_id' => $user_id,
                        'allotment_id' => $allotment_id,
                        'status' => $input['allotment_status'],
                    ];
                    if ($input['allotment_status'] == 2) {
                        $checker = new UserCheck();
                        $checker->scoreUserAllotment($allotment_id, $user_id);
                        $input_create['date_confirm'] = time();
                    }
                    if ($request->has('inspector_amount')) {
                        $input_create['inspector_amount'] = $input['inspector_amount'];
                    }
                    AllotmentUser::create($input_create);
                }
            }
        }

        if ($input['allotment_status'] != 1 and $input['allotment_status'] != 4) {
            if (AllotmentMessage::whereAllotmentId($allotment_id)->whereUserId($user_id)->exists()) {
                AllotmentMessage::whereAllotmentId($allotment_id)->whereUserId($user_id)
                    ->update(['content' => $input['allotment_message']]);
            } else {
                AllotmentMessage::create([
                    'content' => $input['allotment_message'],
                    'admin_id' => Auth::id(),
                    'allotment_id' => $allotment_id,
                    'user_id' => $user_id,
                ]);
            }
        }

        return Redirect::route($back . '.' . $allotment_id)->with('success', 'اطلاعات با موفقیت ذخیره شد.');
    }
}
