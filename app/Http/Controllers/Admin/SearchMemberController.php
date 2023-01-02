<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\SearchMemberRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\City;
use App\Models\Credibility;
use App\Models\Dasteh;
use App\Models\Degree;
use App\Models\FactualyList;
use App\Models\Gerayesh;
use App\Models\MembershipType;
use App\Models\Reshteh;
use App\Models\Shakheh;
use App\Models\Skills;
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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class SearchMemberController extends Controller
{
    public function getIndex()
    {
        $gender = [
            '' => 'انتخاب کنید',
            '1' => 'آقا',
            '2' => 'خانم',
        ];
        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'همه'] + $branch_id;

        $shakhe  = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $shakhe = ['' => 'همه'] + $shakhe;

        $reshteh  = Reshteh::pluck('title', 'id')->all();
        $reshteh = ['' => 'همه'] + $reshteh;

        $dasteh  = Dasteh::pluck('title', 'id')->all();
        $dasteh = ['' => 'همه'] + $dasteh;


        $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'همه'] + $category_id;

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'همه'] + $state_id;

        $degree_id = Degree::Orderby('listorder', 'ASC')->pluck('title', 'title')->all();
        $degree_id = ['' => 'همه'] + $degree_id;

        $credibility_id = Credibility::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $credibility_id = ['' => 'همه'] + $credibility_id;

        $admins = User::whereAdmin(1)->Orderby('family', 'ASC')->select(['name', 'family', 'id'])->get();
        $admin_id = ['' => 'همه'];

        $skills = Skills::Orderby('title', 'ASC')->select(['title', 'id'])->get();
        $skillId = [];

        foreach ($admins as $admin) {
            $admin_id[$admin->id] = $admin->name . ' ' . $admin->family;
        }

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
        $city=City::pluck('title', 'id')->all();

        return view('admin.search-member.index')
            ->with('gender', $gender)
            ->with('dasteh',$dasteh)
            ->with('shakhe', $shakhe)
            ->with('reshteh', $reshteh)
            ->with('state_id', $state_id)
            ->with('skills', $skills)
            ->with('skillId', $skillId)
            ->with('degree_id', $degree_id)
            ->with('credibility_id', $credibility_id)
            ->with('sort', $sort)
            ->with('city',$city)
            ->with('admin_id', $admin_id)
            ->with('branch_id', $branch_id)
            ->with('core_scientific', $core_scientific)
            ->with('interview_type_id', $interview_type_id)
            ->with('category_id', $category_id);

    }

    public function getResualt(Request $request)
    {
        $query = User::query();
        $query->whereNull('delete_temp');
            //->with('admin', 'register', 'userStatus', 'userContent')
            //->join('user_info', 'users.id', '=', 'user_info.user_id');

        if ($request->has('start') and $request->has('end')) {
            $start = explode('/', $request->get('start'));
            $end = explode('/', $request->get('end'));

            $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
            $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

            $query->whereBetween('users.created_at', array($s, $e));
        }
        /*if ($request->has('start_interview') and $request->has('end_interview')) {
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
        */
        if ($request->has('name')) {
            $query->where('users.name', 'LIKE', '%' . $request->get('name') . '%');
        }
        if ($request->has('family')) {
            $query->where('users.family', 'LIKE', '%' . $request->get('family') . '%');
        }
        if ($request->has('mobile1')) {

            $query->where('users.mobile', '>=', $request->get('mobile1'));
        }
        if ($request->has('mobile2')) {

            $query->where('users.mobile', '<=', $request->get('mobile2'));
        }
        /*if ($request->has('mobile')) {
            $query->where('mobile', 'LIKE', '%' . $request->get('mobile') . '%');
        }
        */
        if ($request->has('email')) {
            $query->where('users.email', 'LIKE', '%' . $request->get('email') . '%');
        }
        if ($request->has('user_code')) {
            $query->where('users.user_code', $request->get('user_code'));
        }
        if ($request->has('gender')) {
            $query->where('users.gender', $request->get('gender'));
        }
        /*if ($request->has('admin_id')) {
            $query->where('admin_id', $request->get('admin_id'));
        }*/
        if ($request->has('state')) {
            $query->where('users.state_id', $request->get('state'));
        }
        if ($request->has('city')) {
            $query->where('users.city', 'LIKE', '%' . $request->get('city') . '%');
        }
        if ($request->has('ncode1')) {

            $query->where('users.ncode', '>=', $request->get('ncode1'));
        }
        if ($request->has('ncode2')) {

            $query->where('users.ncode', '<=', $request->get('ncode2'));
        }
        if ($request->has('postal_code1')) {

            $query->where('users.postal_code', '>=' , $request->get('postal_code1'));
        }
        if ($request->has('postal_code2')) {

            $query->where('users.postal_code', '>=' , $request->get('postal_code2'));
        }
        if ($request->has('branch')) {
            $query->where('users.branch', 'LIKE', '%' . $request->get('branch') . '%');
        }
        if ($request->has('shakhe')) {
            $query->where('users.shakhe', $request->get('shakhe'));
        }
        if ($request->has('reshteh')) {
            $query->where('users.reshteh1', $request->get('reshteh'));
        }
        /*
        if ($request->has('degree_id')) {
            $query->where('user_info.grade', $request->get('degree_id'));
        }
        if ($request->has('credibility_id')) {
            $query->where('user_info.credibility_id', $request->get('credibility_id'));
        }
        if ($request->has('interview_type_id')) {
            $query->where('user_info.interview_type_id', $request->get('interview_type_id'));
        }

        if ($request->has('article_title')) {
            $query->where('user_info.article_title', 'LIKE', '%' . $request->get('article_title') . '%');
        }
        if ($request->has('ideas_title')) {
            $query->where('user_info.ideas_title', 'LIKE', '%' . $request->get('ideas_title') . '%');
        }

        if ($request->has('invention_title')) {
            $query->where('user_info.invention_title', 'LIKE', '%' . $request->get('invention_title') . '%');
        }
        if ($request->has('article')) {
            $query->where('user_info.article', $request->get('article'));
        }
        if ($request->has('ideas')) {
            $query->where('user_info.ideas', $request->get('ideas'));
        }
        if ($request->has('invention')) {
            $query->where('user_info.invention', $request->get('invention'));
        }

        if ($request->has('invention_title')) {
            $query->where('user_info.invention_title', 'LIKE', '%' . $request->get('invention_title') . '%');
        }
        if ($request->has('company')) {
            $query->where('user_info.company', 'LIKE', '%' . $request->get('company') . '%');
        }
        if ($request->has('industry')) {
            $query->where('user_info.industry', 'LIKE', '%' . $request->get('industry') . '%');
        }
//        if ($request->has('job_status')) {
//            if ($request->get('job_status') == 1) {
//                $query->where('user_info.job_status', $request->get('job_status'));
//            } else {
//                $query->where('user_info.job_status', '<>', 1);
//            }
//        }
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->get('branch_id'));
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }
        if ($request->has('core_scientific')) {
            $query->where('core_scientific', $request->get('core_scientific'));
        }

        if ($request->has('project_required')) {
            $query->join('project_required', 'users.id', '=', 'project_required.user_id');
            $query->where('project_required.title', 'LIKE', '%' . $request->get('project_required') . '%');
        }

        if ($request->has('content')) {
            $query->join('user_content', 'users.id', '=', 'user_content.user_id');
            $query->where('user_content.content', 'LIKE', '%' . $request->get('content') . '%');
        }

        if ($request->has('skills')) {
            $query->join('skills_user', 'users.id', '=', 'skills_user.user_id');
            $query->whereIn('skills_user.skills_id', $request->get('skills'));
        }

        if ($request->get('sort') == 'date_interview') {
            $query->orderBy('users.date_interview', 'DESC');
        } else {
            $query->orderBy('users.id', 'DESC');
        }
*/
        $data = $query->select([
            'users.id as id',
            'users.name as name',
            'users.family as family',
            'users.user_code as user_code',
            //'users.admin_id as admin_id',
            //'users.register_id as register_id',
            'users.mobile as mobile',
            'users.state as state_id',
            'users.status as status',
            'users.email as email',
            'users.created_at as created_at',
            //'users.date_interview as date_interview',
            //'users.phone_call as phone_call',
        ])->paginate(20);

        return view('admin.search-member.resualt')
            ->with('data', $data);
    }

    public function getEdit($id)
    {

        $data = User::whereNull('delete_temp')
            ->find($id);

        if (!$data) abort(404);

       /* $info_data = UserInfo::whereUserId($id)->first();
        $content_data = UserContent::whereUserId($id)->with('admin')->get();*/

        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'انتخاب کنید . . .'] + $branch_id;

       /* $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'انتخاب کنید . . .'] + $category_id;*/

        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'انتخاب کنید . . .'] + $state_id;

        /*$admins = User::whereAdmin(1)->Orderby('family', 'ASC')->select(['name', 'family', 'id'])->get();
        $admin_id = ['' => 'انتخاب کنید . . .'];
        foreach ($admins as $admin) {
            $admin_id[$admin->id] = $admin->name . ' ' . $admin->family;
        }

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
*/

        $shakhe=Category::pluck('title', 'id')->all();
        //$city=City::pluck('title', 'id')->all();
        $grayesh=Gerayesh::pluck('title', 'id')->all();
        $dasteh=Dasteh::pluck('title', 'id')->all();

        return view('admin.search-member.edit')
           // ->with('membershipType', $membershipType)
           // ->with('degree_id', $degree_id)
           // ->with('credibility_id', $credibility_id)
          //  ->with('groups', $groups)
           // ->with('groupsId', $groupsId)
          //  ->with('skills', $skills)
           // ->with('skillId', $skillId)
            ->with('state_id', $state_id)
           ->with('grayesh', $grayesh)
           ->with('dasteh', $dasteh)
            ->with('shakhe', $shakhe)
            ->with('data', $data)
            ->with('branch_id', $branch_id);

           // ->with('category_id', $category_id);
    }

    public function postEdit($user_id, SearchMemberRequest $request)
    {
        $rules = [
            'email' => 'sometimes|required|email|unique:users,email,' . $user_id,
            'mobile' => 'sometimes|required|iran_mobile|unique:users,mobile,' . $user_id,
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $input = $request->all();
            $user = User::whereNull('delete_temp')
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
            /*
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


                        //$user->factualyList()->detach();
                        if ($request->has('groups')) {
                            $user->assignFactualyList($request['groups']);
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
                        }*/

            $input['user_id'] = $user_id;
            $user->update($input);

 /*

            $userInfo = UserInfo::where('user_id', $user_id)->first();
            $userInfo->update($input);

            if ($request->has('content')) {
                $input['admin_id'] = Auth::user()->id;
                UserContent::create($input);
            }*/
            event(new LogUserEvent($input['user_id'], 'search-member/edit', Auth::user()->id));
            return Redirect::action('Admin\SearchMemberController@getIndex')
                ->with('success', 'کاربر با موفقیت ویرایش شد.');

        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }
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
        return json_encode($data);
    }


    public function getSignIn($id)
    {
        $data = User::whereMember(1)
            ->whereNull('delete_temp')
            ->find($id);
        if (!$data) abort(404);
        Session::put('returnId', Auth::id());
        Session::put('returnUrl', URL::previous());
        Auth::loginUsingId($id);
        return Redirect::action('Auth\LoginController@getCrmLogin');
    }


    public function getChangePassword($id)
    {
        $data = User::whereMember(1)
            ->whereNull('delete_temp')
            ->find($id);
        if (!$data) abort(404);
        return View('admin.search-member.change')
            ->with('data', $data);
    }


    public function postChangePassword($id, SearchMemberRequest $request)
    {
        $data = User::whereMember(1)
            ->whereNull('delete_temp')
            ->find($id);
        if (!$data) abort(404);
        
        $data->password = bcrypt($request->get('password'));
        $data->save();

        return Redirect::back()
            ->with('success', 'رمز عبور با موفقیت تغییر کرد.');
    }


}
