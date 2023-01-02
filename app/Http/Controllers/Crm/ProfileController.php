<?php

namespace App\Http\Controllers\Crm;

use App\Http\Requests\ProfileRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Skills;
use App\Models\State;
use App\Models\UserContent;
use App\Models\UserInfo;
use App\User;
use App\Models\ProfileComment;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function getEdit()
    {
        $id = Auth::User()->id;
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

        $admins = User::whereAdmin(1)->Orderby('family', 'ASC')->select(['name', 'family', 'id'])->get();
        $admin_id = ['' => 'انتخاب کنید . . .'];
        foreach ($admins as $admin) {
            $admin_id[$admin->id] = $admin->name . ' ' . $admin->family;
        }

        $skills = Skills::Orderby('title', 'ASC')->select(['title', 'id'])->get();
        $skillId = [];
        foreach ($data->skill as $item) {
            $skillId[] = $item->id;
        }

        return View('crm.profile.edit')
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

    public function postPro(ProfileRequest $request)
    {
        $user_id = Auth::id();
        $input = $request->all();

        $user = User::whereMember(1)
            ->whereNull('delete_temp')
            ->find($user_id);

        $user->update($input);

        $user->skill()->detach();
        if ($request->has('skills')) {
            $user->assignSkill($request['skills']);
        }

        if (!$request->has('article')) $input['article'] = 0;
        if (!$request->has('invention')) $input['invention'] = 0;
        if (!$request->has('ideas')) $input['ideas'] = 0;
        if (!$request->has('expertise')) $input['expertise'] = 0;

        $userInfo = UserInfo::where('user_id', $user_id)->first();
        if (!$userInfo) abort(404);
        $userInfo->update($input);

        return Redirect::action('Crm\ProfileController@getEdit')
            ->with('success', 'کاربر با موفقیت ویرایش شد.');
    }

    public function postEdit(ProfileRequest $request)
    {
        $user_id = Auth::id();
        $rules = [
            'mobile' => 'required|iran_mobile|unique:users,mobile,' . $user_id,
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $input = $request->except('email');
            $user = User::whereMember(1)
                ->whereNull('delete_temp')
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

            $user->update($input);

            $userInfo = UserInfo::where('user_id', $user_id)->first();
            $userInfo->update($input);

            return Redirect::action('Crm\ProfileController@getEdit')
                ->with('success', 'کاربر با موفقیت ویرایش شد.');
        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }

    public function postPass(ProfileRequest $request)
    {
        $request_data = $request->all();
        $current_password = Auth::User()->password;
        if (Hash::check($request_data['old_password'], $current_password)) {
            $user_id = Auth::id();
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request_data['password']);;
            $obj_user->save();
            return Redirect::action('Crm\ProfileController@getEdit')
                ->with('success', 'کاربر با موفقیت ویرایش شد.');
        } else {
            return Redirect::back()->withInput()->withErrors('رمز عبور فعلی صحیح نیست');
        }
    }

    public function postComment(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'comment' => 'required|min:2',
            'pid' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        if (Auth::Check()) {
            $data = [
                'user_id' => Auth::User()->id,
                'mainuser_id' => $request->get('pid'),
                'comment' => $request->get('comment')
            ];
            ProfileComment::create($data);
            return Redirect::back()
                ->with('success', 'نظر با موفقیت ثبت شد.');
        } else {
            return Redirect::back()->withInput()->withErrors('لطفا وارد شوید.');
        }
    }
}
