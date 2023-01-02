<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\PendingMemberRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Credibility;
use App\Models\Degree;
use App\Models\FactualyList;
use App\Models\MembershipType;
use App\Models\Skills;
use App\Models\State;
use App\Models\UserContent;
use App\Models\UserInfo;
use App\User;
use Classes\DateUtils;
use Classes\UserCheck;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PendingMemberController extends Controller
{
    public function getIndex(Request $request)
    {
        $date = new DateUtils();
        $current_day = $date->current_date();

        $query = User::query();
        $query->pending($current_day['start_date'])
            ->with('admin', 'register', 'userStatus');

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
            if ($request->has('mobile')) {
                $query->where('mobile', 'LIKE', '%' . $request->get('mobile') . '%');
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
        return View('admin.pending.index')
            ->with('state_id', $state_id)
            ->with('sort', $sort)
            ->with('data', $data);
    }

    public function getAdd()
    {
        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'انتخاب کنید . . .'] + $branch_id;

        $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'انتخاب کنید . . .'] + $category_id;

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'انتخاب کنید . . .'] + $state_id;

        $skills = Skills::Orderby('title', 'ASC')->select(['title', 'id'])->get();
        $skillId = [];

        return View('admin.pending.add')
            ->with('skills', $skills)
            ->with('skillId', $skillId)
            ->with('branch_id', $branch_id)
            ->with('state_id', $state_id)
            ->with('category_id', $category_id);
    }

    public function postAdd(PendingMemberRequest $request)
    {
        $checker = new UserCheck();
        $input = $request->all();

        if ($request->has('date_interview') and $request->get('interview_type_id') == 1) {
            if ($request->has('time_interview')) {
                $time_interview = explode(':', $input['time_interview']);
                if (count($time_interview) != 2) {
                    return Redirect::back()
                        ->with('error', 'فرمت ساعت وارد شده اشتباه می باشد.')
                        ->withinput();
                } else {
                    if ($time_interview[0] == "__" || $time_interview[1] == "__") {
                        return Redirect::back()
                            ->with('error', 'فرمت ساعت وارد شده اشتباه می باشد.')
                            ->withinput();
                    }
                }
            } else {
                return Redirect::back()
                    ->with('error', 'فرمت ساعت وارد شده اشتباه می باشد.')
                    ->withinput();
            }
            $date_interview = explode('/', $input['date_interview']);
            $input['date_interview'] = jmktime($time_interview[0], $time_interview[1], 0, $date_interview[1], $date_interview[0], $date_interview[2]);
            $input['for_check'] = jmktime(0, 0, 0, $date_interview[1], $date_interview[0], $date_interview[2]);
            $date_check = $checker->check_capacity($input['for_check']);
            if (!$date_check) {
                return Redirect::back()
                    ->with('error', 'ظرفیت تاریخ انتخابی تکمیل است، تاریخ دیگری را برای مصاحبه انتخاب کنید.')
                    ->withinput();
            }
        } else {
            $input['date_interview'] = time();
        }

        if ($request->has('birth')) {
            $birth = explode('/', $input['birth']);
            if (count($birth) > 1)
                $input['birth'] = jmktime(0, 0, 0, $birth[1], $birth[0], $birth[2]);
            else
                $input['birth'] = null;
        } else {
            $input['birth'] = null;
        }


        if ($request->has('branch_id')) {
            $input['branch_id'] = $request->get('branch_id');
        } else {
            $input['branch_id'] = null;
        }

        if ($request->has('category_id')) {
            $input['category_id'] = $request->get('category_id');
        } else {
            $input['category_id'] = null;
        }

        if ($request->has('state_id')) {
            $input['state_id'] = $request->get('state_id');
        } else {
            $input['state_id'] = null;
        }

        if ($request->has('postal_code')) {
            $input['postal_code'] = $request->get('postal_code');
        } else {
            $input['postal_code'] = 1111111111;
        }

        if ($request->has('father_name')) {
            $input['father_name'] = $request->get('father_name');
        } else {
            $input['father_name'] = '-';
        }

        $input['password'] = bcrypt($input['email']);
        $input['rejection'] = 0;
        $input['member'] = 1;
        $input['status_id'] = 1;
        $input['admin_id'] = Auth::user()->id;

        $user = User::create($input);
        $input['user_id'] = $user->id;
        $input['agent_send'] = 0;

        $input['score'] = 0;
        $input['score_id'] = Degree::where('min', '<=', $input['score'])
            ->where('max', '>', $input['score'])
            ->firstorfail()->title;

        UserInfo::create($input);

        if ($request->has('skills')) {
            $user->assignSkill($request['skills']);
        }

        User::where('id', $input['user_id'])->update(['user_code' => $checker->user_code($input['user_id'])]);

        if ($request->has('content')) {
            UserContent::create($input);
        }
        event(new LogUserEvent($input['user_id'], 'add', Auth::user()->id));
        return Redirect::action('Admin\PendingMemberController@getIndex')
            ->with('success', 'کاربر جدید با موفقیت ثبت شد.');
    }

    public function getEdit($id)
    {
        $date = new DateUtils();
        $current_day = $date->current_date();
        $data = User::pending($current_day['start_date'])
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

        return View('admin.pending.edit')
            ->with('membershipType', $membershipType)
            ->with('degree_id', $degree_id)
            ->with('credibility_id', $credibility_id)
            ->with('groups', $groups)
            ->with('groupsId', $groupsId)
            ->with('skills', $skills)
            ->with('skillId', $skillId)
            ->with('state_id', $state_id)
            ->with('info_data', $info_data)
            ->with('content_data', $content_data)
            ->with('data', $data)
            ->with('branch_id', $branch_id)
            ->with('category_id', $category_id);
    }

    public function postEdit($user_id, PendingMemberRequest $request)
    {
        $rules = [
            'email' => 'sometimes|required|email|unique:users,email,' . $user_id,
            'mobile' => 'sometimes|required|iran_mobile|unique:users,mobile,' . $user_id,
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $input = $request->all();
            $checker = new UserCheck();
            $date = new DateUtils();
            $current_day = $date->current_date();
            $user = User::pending($current_day['start_date'])
                ->find($user_id);

            if ($request->has('date_interview') and $request->get('interview_type_id') == 1) {

                if ($request->has('time_interview')) {
                    $time_interview = explode(':', $input['time_interview']);
                    if (count($time_interview) != 2) {
                        return Redirect::back()
                            ->with('error', 'فرمت ساعت وارد شده اشتباه می باشد.')
                            ->withinput();
                    } else {
                        if ($time_interview[0] == "__" || $time_interview[1] == "__") {
                            return Redirect::back()
                                ->with('error', 'فرمت ساعت وارد شده اشتباه می باشد.')
                                ->withinput();
                        }
                    }
                } else {
                    return Redirect::back()
                        ->with('error', 'فرمت ساعت وارد شده اشتباه می باشد.')
                        ->withinput();
                }

                $date_interview = explode('/', $input['date_interview']);
                $input['date_interview'] = jmktime($time_interview[0], $time_interview[1], 0, $date_interview[1], $date_interview[0], $date_interview[2]);

                if ($input['date_interview'] != jdate('d/m/Y', $user->date_interview, '', '', 'en')) {
                    $input['for_check'] = jmktime(0, 0, 0, $date_interview[1], $date_interview[0], $date_interview[2]);
                    $date_check = $checker->check_capacity($input['for_check']);
                    if (!$date_check) {
                        return Redirect::back()
                            ->with('error', 'ظرفیت تاریخ انتخابی تکمیل است، تاریخ دیگری را برای مصاحبه انتخاب کنید.')
                            ->withinput();
                    }
                }
            } else {
                $input['date_interview'] = time();
            }

            if ($request->get('interview_type_id') == 0) {
                unset($input['date_interview']);
            }

            if ($request->has('birth')) {
                $birth = explode('/', $input['birth']);
                if (count($birth) > 1)
                    $input['birth'] = jmktime(0, 0, 0, $birth[1], $birth[0], $birth[2]);
                else
                    $input['birth'] = null;
            } else {
                $input['birth'] = null;
            }

            if ($request->has('branch_id')) {
                $input['branch_id'] = $request->get('branch_id');
            } else {
                $input['branch_id'] = null;
            }

            if ($request->has('category_id')) {
                $input['category_id'] = $request->get('category_id');
            } else {
                $input['category_id'] = null;
            }

            if ($request->has('state_id')) {
                $input['state_id'] = $request->get('state_id');
            } else {
                $input['state_id'] = null;
            }

            if ($request->has('credibility_id')) {
                $input['credibility_id'] = $request->get('credibility_id');
            } else {
                $input['credibility_id'] = null;
            }

            if ($request->has('degree_id')) {
                $input['degree_id'] = $request->get('degree_id');
            } else {
                $input['degree_id'] = null;
            }

            $user->factualyList()->detach();
            if ($request->has('groups')) {
                $user->assignFactualyList($request['groups']);
            }

            if ($input['member_status_id'] == -1) {
                $input['rejection'] = 1;
            } else {
                $checker->statusDate($user_id, $input['member_status_id']);
                $input['status_id'] = $input['member_status_id'];
                $input['rejection'] = 0;
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
            event(new LogUserEvent($input['user_id'], 'edit', Auth::user()->id));
            return Redirect::action('Admin\PendingMemberController@getIndex')
                ->with('success', 'کاربر با موفقیت ویرایش شد.');

        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }

    public function getEmail($user_id)
    {
        $checker = new UserCheck();
        $data = $checker->getInvitationEmail($user_id);
        return json_encode($data);
    }

    public function getDeleteContent($content_id)
    {
        $checker = new UserCheck();
        $data = $checker->getDeleteContent($content_id);
        return json_encode($data);
    }

    public function getCaller($user_id)
    {
        $checker = new UserCheck();
        $data = $checker->getCaller($user_id);
        return json_encode($data);
    }

    public function postDelete(PendingMemberRequest $request)
    {
        User::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);
        return Redirect::action('Admin\PendingMemberController@getIndex')
            ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');

    }
}
