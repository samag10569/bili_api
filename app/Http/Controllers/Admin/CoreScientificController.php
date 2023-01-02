<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CoreScientificRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\FactualyList;
use App\User;
use Classes\Resizer;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CoreScientificController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = User::query();
        $query->whereCoreScientific(1);

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

        return View('admin.core-scientific.index')
            ->with('data', $data);
    }

    public function getAdd()
    {

        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'انتخاب کنید . . .'] + $branch_id;

        $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'انتخاب کنید . . .'] + $category_id;

        $groups = FactualyList::whereType(2)->whereVersion(1)->select(['title', 'id'])->get();
        $groupsId = [];
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.core-scientific.add')
            ->with('status', $status)
            ->with('groups', $groups)
            ->with('branch_id', $branch_id)
            ->with('category_id', $category_id)
            ->with('groupsId', $groupsId);


    }

    public function postAdd(CoreScientificRequest $request)
    {
        $input = $request->all();

        $user = User::whereId($input['user_id'])
            ->where('core_scientific', 0)
            ->whereMember(1)
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

        $input['core_scientific'] = 1;
        $user->update($input);

        if ($request->has('groups')) {
            $user->assignFactualyList($request['groups']);
        }
        return Redirect::action('Admin\CoreScientificController@getIndex')->with('success', 'آیتم جدید اضافه شد.');
    }

    public function getEdit($id)
    {
        $branch_id = Branch::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $branch_id = ['' => 'انتخاب کنید . . .'] + $branch_id;

        $category_id = Category::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'انتخاب کنید . . .'] + $category_id;

        $data = User::where('core_scientific', 1)->find($id);
        if (!$data) abort(404);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $groups = FactualyList::whereType(2)->whereVersion(1)->select(['title', 'id'])->get();
        $groupsId = [];
        foreach ($data->factualyList as $item) {
            $groupsId[] = $item->id;
        }
        return View('admin.core-scientific.edit')
            ->with('status', $status)
            ->with('groups', $groups)
            ->with('groupsId', $groupsId)
            ->with('category_id', $category_id)
            ->with('branch_id', $branch_id)
            ->with('data', $data);

    }

    public function postEdit($id, CoreScientificRequest $request)
    {
        $rules = ['email' => 'required|email|unique:users,email,' . $id];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $input = Input::except(['password', '_token', 'repassword', 'groups']);

            $user = User::find($id);

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

            $user->update($input);

            $user->factualyList()->detach();
            if ($request->has('groups')) {
                $user->assignFactualyList($request['groups']);
            }
            return Redirect::action('Admin\CoreScientificController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');
        } else {
            return Redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function postDelete(CoreScientificRequest $request)
    {
        $images = User::whereIn('id', $request->get('deleteId'))
            ->whereCoreScientific(1)
            ->select('image', 'id', 'admin', 'member')
            ->get();
        foreach ($images as $item) {
            File::delete('assets/uploads/user/big/' . $item->image);
            File::delete('assets/uploads/user/medium/' . $item->image);
            if ($item->member || $item->admin) {
                $item->update(['core_scientific' => 0]);
            } else {
                $item->delete();
            }
        }
        return Redirect::action('Admin\CoreScientificController@getIndex')
            ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
    }

    public function getUserAjax($id = null)
    {
        $user = User::whereMember(1)->where('core_scientific', 0)->find($id);
        if ($user) {
            $json = $user->toJson();
            return json_encode(array('status' => true, 'text' => $user->name . ' ' . $user->family, 'user' => $json));
        } else {
            return json_encode(array('status' => false, 'text' => 'کد یکتا اشتباه است و یا کاربر قبلا عضو هسته علمی شده است.'));
        }
    }
}
