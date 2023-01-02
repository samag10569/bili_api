<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\AssignedServeRequest;
use App\Models\Allotment;
use App\Models\AllotmentCategory;
use App\Models\AllotmentOption;
use App\Models\AllotmentUser;
use App\Models\Branch;
use App\Models\Category;
use App\Models\FactualyList;
use App\Models\FactualyUser;
use App\Models\State;
use App\Models\UserContent;
use App\Models\UserInfo;
use App\User;
use Classes\UploadImg;
use Classes\UserCheck;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AssignedServeController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = User::query();
        $query->userWithStatus(3)
            ->with('admin', 'info', 'register', 'userStatus');

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

        $data = $query->select([
            'users.id as id',
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
            'users.phone_call as phone_call',
        ])->paginate(15);

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $sort = [
            'id' => 'کد یکتا',
            'date_interview' => 'تاریخ مصاحبه',
        ];
        return View('admin.assigned-serve.index')
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }


    public function getEdit($id)
    {
        $data = User::userWithStatus(3)
            ->find($id);
        if (!$data) abort(404);

        $info_data = UserInfo::whereUserId($id)->first();
        $content_data = UserContent::whereUserId($id)->with('admin')->get();

        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'انتخاب کنید . . .'] + $branch_id;

        $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'انتخاب کنید . . .'] + $category_id;

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'انتخاب کنید . . .'] + $state_id;

        $admins = User::whereAdmin(1)->Orderby('family', 'ASC')->select(['name', 'family', 'id'])->get();
        $admin_id = ['' => 'انتخاب کنید . . .'];
        foreach ($admins as $admin) {
            $admin_id[$admin->id] = $admin->name . ' ' . $admin->family;
        }

        $allotment = AllotmentUser::where('user_id', $id)->count();

        return View('admin.assigned-serve.edit')
            ->with('allotment', $allotment)
            ->with('state_id', $state_id)
            ->with('admin_id', $admin_id)
            ->with('info_data', $info_data)
            ->with('content_data', $content_data)
            ->with('data', $data)
            ->with('branch_id', $branch_id)
            ->with('category_id', $category_id);
    }

    public function postEdit($user_id, AssignedServeRequest $request)
    {
        $rules = [
            'email' => 'sometimes|required|email|unique:users,email,' . $user_id,
            'mobile' => 'sometimes|required|iran_mobile|unique:users,mobile,' . $user_id,
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $input = $request->all();
            $user = User::userWithStatus(3)
                ->find($user_id);

            if ($request->hasFile('image')) {
                $uploader = new UploadImg();
                $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/user/');
                $pathBig = 'assets/uploads/user/big/';
                $pathMedium = 'assets/uploads/user/medium/';
                File::delete($pathBig . $user->image);
                File::delete($pathMedium . $user->image);
                if ($fileName) {
                    $input['image'] = $fileName;
                } else {
                    return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
                }
            }

            $birth = explode('/', $input['birth']);
            $input['birth'] = jmktime(0, 0, 0, $birth[1], $birth[0], $birth[2]);
            if ($user->admin_id == null) {
                $input['admin_id'] = Auth::user()->id;
            }

            if ($input['member_status_id'] == -1) {
                $input['rejection'] = 1;
            } else {
                $checker = new UserCheck();
                $checker->statusDate($user_id, $input['member_status_id']);
                $input['status_id'] = $input['member_status_id'];
                $input['rejection'] = 0;
            }

            $input['user_id'] = $user_id;
            $user->update($input);

            if (!$request->has('article')) {
                $input['article'] = 0;
            }
            if (!$request->has('invention')) {
                $input['invention'] = 0;
            }
            if (!$request->has('ideas')) {
                $input['ideas'] = 0;
            }
            if (!$request->has('expertise')) {
                $input['expertise'] = 0;
            }

            $userInfo = UserInfo::where('user_id', $user_id)->first();
            $userInfo->update($input);

            if ($request->has('content')) {
                $input['admin_id'] = Auth::user()->id;
                UserContent::create($input);
            }
            event(new LogUserEvent($input['user_id'], 'edit', Auth::user()->id));
            return Redirect::action('Admin\AssignedServeController@getIndex')
                ->with('success', 'کاربر با موفقیت ویرایش شد.');

        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }

    public function getDeleteContent($content_id)
    {
        $checker = new UserCheck();
        $data = $checker->getDeleteContent($content_id);
        event(new LogUserEvent($content_id, 'delete', Auth::user()->id));
        return json_encode($data);
    }


    public function getDeleteOption($option_id)
    {
        $checker = new UserCheck();
        $data = $checker->getDeleteOption($option_id);
        event(new LogUserEvent($option_id, 'delete', Auth::user()->id));
        return json_encode($data);
    }

    public function postDelete(AssignedServeRequest $request)
    {
        User::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);
        return Redirect::action('Admin\AssignedServeController@getIndex')
            ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');

    }

    public function getAllotment($user_id)
    {
        $user = User::select('id', 'name', 'family', 'user_code', 'supervisor', 'factualy_id')->find($user_id);
        $allotment_data = [];
        $allotment_category = AllotmentCategory::with('allotment')->orderby('listorder', 'ASC')->get();
        $allotments = Allotment::all();
        foreach ($allotments as $allotment) {
            $allotment_data[$allotment->id] = null;
            if (AllotmentUser::whereUserId($user_id)->whereAllotmentId($allotment->id)->exists()) {
                $allotment_data[$allotment->id] = AllotmentUser::whereUserId($user_id)->whereAllotmentId($allotment->id)->first()->status;
            }
        }

        $factualy = FactualyList::whereType(2)->whereVersion(1)->pluck('title', 'id')->all();
        $factualy = ['' => 'انتخاب کنید . . .'] + $factualy;
        if ($user->supervisor != null) {

            $factualyList = FactualyUser::whereFactualyListId($user->factualy_id)->pluck('user_id')->all();
            $supervisorList = User::whereIn('id', $factualyList)
                ->whereCoreScientific(1)
                ->select('id', 'name', 'family')
                ->get();

            $supervisor = [];
            foreach ($supervisorList as $row) {
                $supervisor[$row->id] = $row->name . " " . $row->family;
            }
        } else {
            $supervisor = ['' => 'انتخاب کنید . . .'];
        }


        return View('admin.assigned-serve.allotment')
            ->with('factualy', $factualy)
            ->with('user', $user)
            ->with('supervisor', $supervisor)
            ->with('allotment_category', $allotment_category)
            ->with('allotment_data', $allotment_data);
    }

    public function postAllotment($user_id, Request $request)
    {
        $allotments = Allotment::all();
        foreach ($allotments as $allotment) {

            if ($allotment->option) {
                foreach ($request->get($allotment->id . 'allotment_option') as $option) {
                    $input_option = [
                        'user_id' => $user_id,
                        'allotment_id' => $allotment->id,
                        'admin_id' => Auth::user()->id,
                        'content' => $option,
                    ];
                    AllotmentOption::create($input_option);
                }
            }
            $check = AllotmentUser::whereUserId($user_id)->whereAllotmentId($allotment->id)->exists();
            if ($check) {
                if ($request->get($allotment->id) == 0) {
                    AllotmentUser::whereUserId($user_id)
                        ->whereAllotmentId($allotment->id)
                        ->delete();
                } else {
                    $allotment_check = AllotmentUser::whereUserId($user_id)->whereAllotmentId($allotment->id)->first();
                    if ($request->get($allotment->id) == 2) {
                        AllotmentUser::whereUserId($user_id)
                            ->whereAllotmentId($allotment->id)
                            ->update(['status' => $request->get($allotment->id)]);
                    } else {
                        if ($allotment_check->status == 2) {
                            AllotmentUser::whereUserId($user_id)
                                ->whereAllotmentId($allotment->id)
                                ->update(['status' => $request->get($allotment->id)]);
                        }
                    }
                }
            } else {
                if ($request->get($allotment->id) != 0) {

                    $input = [
                        'admin_id' => Auth::user()->id,
                        'user_id' => $user_id,
                        'allotment_id' => $allotment->id,
                        'status' => $request->get($allotment->id),
                    ];
                    if ($request->get($allotment->id) == 2) {
                        $input['date_confirm'] = time();
                    }

                    AllotmentUser::create($input);
                }
            }
        }
        if ($request->has('supervisor')) {
            User::whereId($user_id)->update(['supervisor' => $request->get('supervisor'), 'factualy_id' => $request->get('factualy')]);
        }

        event(new LogUserEvent($user_id, 'allotment', Auth::user()->id));
        return Redirect::action('Admin\AssignedServeController@getEdit', $user_id)->with('success', 'تخصیص خدمت فناور با موفقیت انجام شد.');
    }

    public function postSupervisorAjax(Request $request)
    {
        $input = $request->all();
        $factualyList = FactualyUser::whereFactualyListId($input['key'])->pluck('user_id')->all();
        $supervisor = User::whereIn('id', $factualyList)
            ->whereCoreScientific(1)
            ->select('id', 'name', 'family')
            ->get();

        $returnValue['value'] = "";
        foreach ($supervisor as $row) {
            $returnValue['value'] .= "<option value='$row->id'>" . $row->name . " " . $row->family . "</option>";
        }

        $returnValue['status'] = true;
        return json_encode($returnValue);
    }

}
