<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\SmsSendRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Credibility;
use App\Models\Degree;
use App\Models\SmsSend;
use App\Models\SmsSendUser;
use App\Models\State;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SmsSendController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = SmsSend::query();
        $query->whereType('sms')
            ->with('smsUser', 'smsUserSuccess');
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('subject')) {
                $query->where('subject', $request->get('subject'));
            }
        }
        $data = $query->latest()->paginate(15);

        return View('admin.sms-send.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'همه'] + $branch_id;

        $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'همه'] + $category_id;

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $degree_id = Degree::Orderby('listorder', 'ASC')->pluck('title', 'title')->all();
        $degree_id = ['' => 'همه'] + $degree_id;

        $credibility_id = Credibility::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $credibility_id = ['' => 'همه'] + $credibility_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];

        $core_scientific = [
            '' => 'همه',
            '0' => 'ندارد',
            '1' => 'دارد',
        ];

        $interview_type_id = [
            '' => 'همه',
            '0' => 'غیر حضوری',
            '1' => 'حضوری',
        ];

        return view('admin.sms-send.add')
            ->with('state_id', $state_id)
            ->with('degree_id', $degree_id)
            ->with('credibility_id', $credibility_id)
            ->with('sort', $sort)
            ->with('branch_id', $branch_id)
            ->with('core_scientific', $core_scientific)
            ->with('interview_type_id', $interview_type_id)
            ->with('category_id', $category_id);

    }

    public function postAdd(Request $request)
    {
        $input = $request->all();
        $input['type'] = 'sms';
        $sms_send = SmsSend::create($input);

        $query = User::query();
        $query->userSearch()
            ->with('admin', 'register', 'userStatus', 'userContent')
            ->join('user_info', 'users.id', '=', 'user_info.user_id');

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


        if (!$request->has('status_id_1') and !$request->has('status_id_2') and !$request->has('status_id_3') and !$request->has('status_id_4') and !$request->has('status_id_5')) {

        } else {
            $status = [];
            if ($request->has('status_id_1')) $status[] = $request->get('status_id_1');

            if ($request->has('status_id_2')) $status[] = $request->get('status_id_2');

            if ($request->has('status_id_3')) $status[] = $request->get('status_id_3');

            if ($request->has('status_id_4')) $status[] = $request->get('status_id_4');

            if ($request->has('status_id_5')) $status[] = $request->get('status_id_5');

            $query->whereIn('status_id', $status);
        }

        if ($request->has('rejection')) {
            $query->where('rejection', $request->get('rejection'));
        }
        if ($request->has('state_id')) {
            $query->where('user_info.state_id', $request->get('state_id'));
        }
        if ($request->has('degree_id')) {
            $query->where('user_info.grade', $request->get('degree_id'));
        }
        if ($request->has('credibility_id')) {
            $query->where('user_info.credibility_id', $request->get('credibility_id'));
        }
        if ($request->has('interview_type_id')) {
            $query->where('user_info.interview_type_id', $request->get('interview_type_id'));
        }
        if ($request->has('branch')) {
            $query->where('user_info.branch', 'LIKE', '%' . $request->get('branch') . '%');
        }
        if ($request->has('city')) {
            $query->where('user_info.city', 'LIKE', '%' . $request->get('city') . '%');
        }
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->get('branch_id'));
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }
        if ($request->has('core_scientific')) {
            $query->where('core_scientific', $request->get('core_scientific'));
        }

        $data = $query->select([
            'users.id as id',
        ])->get();

        foreach ($data as $item) {
            $input_user = [
                'sms_send_id' => $sms_send->id,
                'user_id' => $item->id,
                'status' => 0,
                'type' => $sms_send->type,
            ];
            SmsSendUser::create($input_user);
        }
        event(new LogUserEvent($sms_send->id, 'add', Auth::user()->id));
        return Redirect::action('Admin\SmsSendController@getIndex')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function postDelete(Request $request)
    {
        SmsSendUser::whereIn('sms_send_id', $request->get('deleteId'))->delete();
        if (SmsSend::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\SmsSendController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

}
