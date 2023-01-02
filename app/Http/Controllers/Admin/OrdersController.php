<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\OrdersRequest;
use App\Models\Allotment;
use App\Models\AllotmentCategory;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Credibility;
use App\Models\Degree;
use App\Models\FactualyList;
use App\Models\MembershipType;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Models\OrdersMembershipType;
use App\Models\Skills;
use App\Models\State;
use App\Models\Transaction;
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

class OrdersController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = Orders::query();
        $query->with('user');

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('user_id')) {
                $query->where('user_id', $request->get('user_id'));
            }
            if ($request->has('id')) {
                $query->where('id', $request->get('id'));
            }
            if ($request->has('payments')) {
                $query->where('payments', $request->get('payments'));
            }
            if ($request->has('tracking_code')) {
                $query->where('tracking_code', $request->get('tracking_code'));
            }
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
        }

        $data = $query->latest()->paginate(15);

        $status = [
            '' => 'همه',
            '0' => 'ناموفق',
            '1' => 'موفق',
        ];
        return View('admin.orders.index')
            ->with('status', $status)
            ->with('data', $data);
    }

    public function getMembershipType(Request $request)
    {
        $query = OrdersMembershipType::query();
        $query->with('user');

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('user_id')) {
                $query->where('user_id', $request->get('user_id'));
            }
            if ($request->has('id')) {
                $query->where('id', $request->get('id'));
            }
            if ($request->has('payments')) {
                $query->where('payments', $request->get('payments'));
            }
            if ($request->has('tracking_code')) {
                $query->where('tracking_code', $request->get('tracking_code'));
            }
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
        }

        $data = $query->latest()->paginate(15);

        $status = [
            '' => 'همه',
            '0' => 'ناموفق',
            '1' => 'موفق',
        ];
        return View('admin.orders.membership')
            ->with('status', $status)
            ->with('data', $data);
    }

    public function getMembershipTypeUser(Request $request)
    {
        $query = User::query();
        $query->whereMember(1)
            ->join('user_info', 'users.id', '=', 'user_info.user_id')
            ->whereIn('user_info.membership_type_id', [3, 4])
            ->with('admin', 'info', 'register', 'userStatus', 'info.membershipType');

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
                $query->where('user_info.state_id', $request->get('state_id'));
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
        return View('admin.orders.membership-user')
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getFactor($id)
    {
        $order = Orders::whereId($id)
            ->with('item', 'user')
            ->first();
        return View('admin.orders.factor')
            ->with('order', $order);
    }

    public function getAllotment(Request $request)
    {
        $query = Allotment::query();

        if ($request->has('search')) {

            if ($request->has('id')) {
                $query->where('id', $request->get('id'));
            }
            if ($request->has('title')) {
                $query->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }
            if ($request->has('category_id')) {
                $query->where('category_id', $request->get('category_id'));
            }
        }

        $allotment = $query->paginate(15);
        $allotment_category = AllotmentCategory::pluck('title', 'id')->all();
        $allotment_category = ['' => 'همه'] + $allotment_category;

        return View('admin.orders.allotment')
            ->with('allotment_category', $allotment_category)
            ->with('allotment', $allotment);
    }

    public function getAllotmentUser($allotment_id, Request $request)
    {
        $query = OrderItem::query();
        $query->join('orders', 'order_item.order_id', '=', 'orders.id')
            ->where('order_item.allotment_id', $allotment_id)
//            ->where('orders.status', 1)
            ->with('orders', 'orders.user', 'allotment');
        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('user_code') || $request->has('email')) {
                $query->join('users', 'orders.user_id', '=', 'users.id');
            }
            if ($request->has('user_code')) {
                $query->where('users.user_code', $request->get('user_code'));
            }
            if ($request->has('email')) {
                $query->where('users.email', $request->get('email'));
            }
            if ($request->has('user_id')) {
                $query->where('orders.user_id', $request->get('user_id'));
            }
        }

        $data = $query->select([
            'orders.id as id',
            'orders.status as status',
            'orders.user_id as user_id',
            'orders.created_at as created_at',
            'order_item.total_price as total_price',
            'order_item.allotment_id as allotment_id',
            'order_item.order_id as order_id',
        ])->paginate(15);

        return View('admin.orders.allotment-user')
            ->with('data', $data);


    }

    public function getTransactions(Request $request)
    {
        $query = Transaction::query();
        $query->with('orders', 'orders.user', 'ordersMembershipType', 'ordersMembershipType.user');

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jalali_to_gregorian($start[2], $start[1], $start[0], '-');
                $e = jalali_to_gregorian($end[2], $end[1], $end[0], '-');

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('price')) {
                $query->where('price', $request->get('price'));
            }
            if ($request->has('tracking_code')) {
                $query->where('tracking_code', $request->get('tracking_code'));
            }
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
        }

        $data = $query->latest()->paginate(15);

        $status = [
            '' => 'همه',
            'FAILED' => 'ناموفق',
            'SUCCEED' => 'موفق',
            'INIT' => 'مشکل از درگاه',
        ];
        return View('admin.orders.transaction')
            ->with('status', $status)
            ->with('data', $data);
    }

    public function getEdit($id)
    {
        $data = User::whereMember(1)
            ->whereNull('delete_temp')
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

        $credibility_id = Credibility::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $credibility_id = ['' => 'انتخاب کنید . . .'] + $credibility_id;

        $degree_id = Degree::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $degree_id = ['' => 'انتخاب کنید . . .'] + $degree_id;

        $membershipType = MembershipType::where('id', '<>', 2)->get();

        $skills = Skills::Orderby('title', 'ASC')->select(['title', 'id'])->get();
        $skillId = [];
        foreach ($data->skill as $item) {
            $skillId[] = $item->id;
        }

        $groups = FactualyList::whereType(2)->whereVersion(1)->select(['title', 'id'])->get();
        $groupsId = [];
        foreach ($data->factualyList as $item) {
            $groupsId[] = $item->id;
        }

        $admins = User::whereAdmin(1)->Orderby('family', 'ASC')->select(['name', 'family', 'id'])->get();
        $admin_id = ['' => 'انتخاب کنید . . .'];
        foreach ($admins as $admin) {
            $admin_id[$admin->id] = $admin->name . ' ' . $admin->family;
        }

        return View('admin.orders.edit')
            ->with('membershipType', $membershipType)
            ->with('credibility_id', $credibility_id)
            ->with('degree_id', $degree_id)
            ->with('groups', $groups)
            ->with('groupsId', $groupsId)
            ->with('skills', $skills)
            ->with('skillId', $skillId)
            ->with('state_id', $state_id)
            ->with('admin_id', $admin_id)
            ->with('info_data', $info_data)
            ->with('content_data', $content_data)
            ->with('data', $data)
            ->with('branch_id', $branch_id)
            ->with('category_id', $category_id);
    }

    public function postEdit($user_id, OrdersRequest $request)
    {
        $rules = ['email' => 'sometimes|required|email|unique:users,email,' . $user_id];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $input = $request->all();
            $user = User::whereMember(1)
                ->whereNull('delete_temp')
                ->find($user_id);
            $userInfo = UserInfo::whereUserId($user_id)
                ->first();

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

            if ($request->has('birth')) {
                $birth = explode('/', $input['birth']);
                $input['birth'] = jmktime(0, 0, 0, $birth[1], $birth[0], $birth[2]);
            } else {
                $input['birth'] = null;
            }

            if (!$request->has('admin_id')) {
                $input['admin_id'] = null;
            }

            if ($input['member_status_id'] == -1) {
                $input['rejection'] = 1;
            } else {
                $checker = new UserCheck();
                $checker->statusDate($user_id, $input['member_status_id']);
                $input['status_id'] = $input['member_status_id'];
                $input['rejection'] = 0;
            }

            if (Auth::user()->hasPermission('orders.membershipTypeEdit')) {
                if ($input['membership_type_id'] != $userInfo->membership_type_id) {
                    if ($input['membership_type_id'] == 3 || $input['membership_type_id'] == 4) {
                        $input['date_membership_type'] = time();
                        $input['status_membership_type'] = 1;
                    } else {
                        $input['date_membership_type'] = null;
                    }
                } else {
                    unset($input['membership_type_id']);
                }
            } else {
                unset($input['membership_type_id']);
            }

            $input['user_id'] = $user_id;
            $user->update($input);

            $user->skill()->detach();
            if ($request->has('skills')) {
                $user->assignSkill($request['skills']);
            }

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
            event(new LogUserEvent($input['user_id'], 'orders/edit', Auth::user()->id));
            return Redirect::action('Admin\OrdersController@getMembershipTypeUser')
                ->with('success', 'کاربر با موفقیت ویرایش شد.');

        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }

    public function getEquivalentPersian(Request $request, $temp = false)
    {
        if ($temp) {
            $table = 'grade_temp';
        } else {
            $table = 'grade';
        }

        $query = User::query();
        $query->whereMember(1)
            ->join($table, 'users.id', '=', $table . '.user_id')
            ->where($table . '.equivalent_persian', 1)
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
                $query->where('user_info.state_id', $request->get('state_id'));
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

        return View('admin.orders.grade')
            ->with('state_id', $state_id)
            ->with('temp', $temp)
            ->with('sort', $sort)
            ->with('data', $data);
    }
}

