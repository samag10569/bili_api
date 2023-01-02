<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\UserRequest;
use App\Models\AllotmentCategory;
use App\Models\Role;
use App\User;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = User::query();
        $query->whereAdmin(1);

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
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
        }

        $data = $query->paginate(15);

        return View('admin.user.index')
            ->with('data', $data);
    }


    public function getIndexCredit(Request $request)
    {
        $query = User::where('credit','>',0);

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
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
        }

        $data = $query->paginate(15);

        return View('admin.user.creditindex')
            ->with('data', $data);
    }

    public function getAdd(Request $request)
    {

        $groups = Role::all();
        $groupsId = array();
        if ($request->has('group')) {
            foreach ($request->old('group') as $id) {
                $groupsId[] = $id;
            }
        }
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        return View('admin.user.add')
            ->with('status', $status)
            ->with('groups', $groups)
            ->with('groupsId', $groupsId);

    }


    public function postAdd(UserRequest $request)
    {

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/user/';
                $pathMain = 'assets/uploads/user/main/';
                $pathBig = 'assets/uploads/user/big/';
                $pathMedium = 'assets/uploads/user/medium/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                if (!File::isDirectory($pathMain)) {
                    File::makeDirectory($pathMain);
                }
                if (!File::isDirectory($pathBig)) {
                    File::makeDirectory($pathBig);
                }
                if (!File::isDirectory($pathMedium)) {
                    File::makeDirectory($pathMedium);
                }
                $fileName = md5(microtime()) . ".$extension";
                $request->file('image')->move($pathMain, $fileName);
                $kaboom = explode(".", $fileName);
                $fileExt = end($kaboom);
                Resizer::resizePic($pathMain . $fileName, $pathMedium . $fileName, 400, 400, $fileExt);
                Resizer::resizePic($pathMain . $fileName, $pathBig . $fileName, 800, 800, $fileExt, True);
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }

        $input = $request->all();
        $input['admin'] = $request->has('admin');
        $input['out'] = $request->has('out');
        $input['password'] = bcrypt($request->get('password'));
        $user = User::create($input);
        if ($request->has('group')) {
            $user->assignRole($request['group']);
        }
        event(new LogUserEvent($user->id, 'add', Auth::user()->id));
        return Redirect::action('Admin\UserController@getIndex')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function getEdit($id, Request $request)
    {

        $groups = Role::all();
        $data = User::whereMember(0)->find($id);
        $groupsId = array();

        foreach ($data->roles as $role) {
            $groupsId[] = $role->id;
        }

        if ($request->has('group')) {
            foreach ($request->old('group') as $id) {
                $groupsId[] = $id;
            }
        }
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.user.edit')
            ->with('status', $status)
            ->with('data', $data)
            ->with('groups', $groups)
            ->with('groupsId', $groupsId);

    }


    public function postEdit($id, UserRequest $request)
    {
        $rules = ['email' => 'required|email|unique:users,email,' . $id];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $input = Input::except(['password', '_token', 'repassword', 'group']);
            if ($request->has('password')) {
                $input['password'] = bcrypt($request->get('password'));
            }
            $user = User::whereMember(0)->find($id);
            if ($request->hasFile('image')) {
                $path = 'assets/uploads/user/';
                $pathMain = 'assets/uploads/user/main/';
                $pathBig = 'assets/uploads/user/big/';
                $pathMedium = 'assets/uploads/user/medium/';
                File::delete($pathBig . $user->image);
                File::delete($pathMedium . $user->image);
                $extension = $request->file('image')->getClientOriginalExtension();
                $ext = ['jpg', 'jpeg', 'png'];
                if (in_array($extension, $ext)) {
                    if (!File::isDirectory($path)) {
                        File::makeDirectory($path);
                    }
                    if (!File::isDirectory($pathMain)) {
                        File::makeDirectory($pathMain);
                    }
                    if (!File::isDirectory($pathBig)) {
                        File::makeDirectory($pathBig);
                    }
                    if (!File::isDirectory($pathMedium)) {
                        File::makeDirectory($pathMedium);
                    }
                    $fileName = md5(microtime()) . ".$extension";
                    $request->file('image')->move($pathMain, $fileName);
                    $kaboom = explode(".", $fileName);
                    $fileExt = end($kaboom);
                    Resizer::resizePic($pathMain . $fileName, $pathMedium . $fileName, 400, 400, $fileExt);
                    Resizer::resizePic($pathMain . $fileName, $pathBig . $fileName, 800, 800, $fileExt, True);
                    $input['image'] = $fileName;
                } else {
                    return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
                }
            }
            $input['admin'] = $request->has('admin');
            $input['out'] = $request->has('out');
            $user->where('id', $id)->update($input);
            $user->roles()->detach();
            if ($request->has('group')) {
                $user->assignRole($request['group']);
            }
            event(new LogUserEvent($user->id, 'edit', Auth::user()->id));
            return Redirect::action('Admin\UserController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');
        } else {
            return Redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function postBan(Request $request)
    {
        echo $request->get('type');
        if ($request->get('type') == 'on') {
            $user = User::find($request->get('id'));
            $user->ban = 0;
            $user->save();

        } elseif ($request->get('type') == 'off') {
            $user = User::find($request->get('id'));
            $user->ban = 1;
            $user->save();
        }

        return Response::json(array(
            'error' => false,
        ));

    }

    public function postDelete(UserRequest $request)
    {
        $images = User::whereIn('id', $request->get('deleteId'))->pluck('image', 'id')->all();
        foreach ($images as $key => $item) {
            event(new LogUserEvent($key, 'delete', Auth::user()->id));
            File::delete('assets/uploads/user/big/' . $item);
            File::delete('assets/uploads/user/medium/' . $item);
        }
        if (User::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\UserController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function getGroup()
    {
        $groups = Role::paginate(15);
        return View('admin.user.group.index')
            ->with('data', $groups);
    }

    public function getGroupAdd()
    {

        $allotment_category = AllotmentCategory::whereStatus(1)
            ->orderby('listorder', 'ASC')
            ->with('allotment')
            ->get();
        return View('admin.user.group.add')
            ->with('allotment_category', $allotment_category);
    }

    public function postGroupAdd(UserRequest $request)
    {

        $role = new Role();
        $role->name = $request->get('name');
        $role->permission = serialize($request['access'] + ['fullAccess' => 0]);
        $role->save();
        event(new LogUserEvent($role->id, 'add', Auth::user()->id));
        if ($role->save()) {
            return Redirect::action('Admin\UserController@getGroup')->with('success', 'آیتم جدید اضافه شد.');
        }

    }

    public function getGroupEdit($id)
    {
        $data = Role::findorfail($id);
        $allotment_category = AllotmentCategory::whereStatus(1)
            ->orderby('listorder', 'ASC')
            ->with('allotment')
            ->get();
        return View('admin.user.group.edit')
            ->with('allotment_category', $allotment_category)
            ->with('data', $data);
    }

    public function postGroupEdit($id, UserRequest $request)
    {
        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->permission = serialize($request['access'] + ['fullAccess' => 0]);
        $role->save();

        if ($role->save()) {
            event(new LogUserEvent($role->id, 'edit', Auth::user()->id));
            return Redirect::action('Admin\UserController@getGroup')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');
        }

    }


    public function postGroupDelete(UserRequest $request)
    {
        if (Role::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\UserController@getGroup')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function getChangePassword()
    {
        return View('admin.user.change');
    }

    public function postChangePassword(UserRequest $request)
    {
        $user = User::find(Auth::user()->id);

        $user->password = bcrypt($request->get('password'));

        $user->save();

        if ($user->save()) {
            event(new LogUserEvent($user->id, 'edit', Auth::user()->id));
            return Redirect::back()->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');
        }

    }
}
