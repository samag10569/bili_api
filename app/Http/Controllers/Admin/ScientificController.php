<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ScientificRequest;
use App\Models\Scientific;
use App\Models\ScientificCategory;
use App\User;
use Classes\Resizer;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Classes\MakeTree;

class ScientificController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Scientific::query();
        $query->with('user', 'category');
        $query->where('isadmin',1);

        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('title')) {
                $query->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }
            if ($request->has('category_id')) {
                $query->where('category_id', $request->get('category_id'));
            }

        }

        if (!$request->has('sort')) {
            $query->orderBy('scientific.id', 'DESC');
        }
        $query->deleteTemp();
        $data = $query->paginate(15);

        $category = ScientificCategory::get()->toArray();
        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }
        $category = ['' => 'همه'] + (array)$category;
        return View('admin.scientific.index')
            ->with('data', $data)
            ->with('category', $category);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $category = ScientificCategory::get()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }

        return View('admin.scientific.add')->with('status', $status)
            ->with('category', $category);
    }

    public function postAdd(ScientificRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/scientific/');
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        $input['user_id'] = Auth::User()->id;
        $user=User::find(Auth::User()->id);
        $input['isadmin']=$user->admin;

        Scientific::create($input);

        return Redirect::action('Admin\ScientificController@getIndex')
            ->with('success', 'مطلب جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Scientific::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $category = ScientificCategory::get()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }

        return View('admin.scientific.edit')
            ->with('data', $data)->with('status', $status)
            ->with('category', $category);

    }


    public function postEdit($id, ScientificRequest $request)
    {
        $input = $request->except('_token');

        $scientific = Scientific::find($id);
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/scientific/');
            $pathBig = 'assets/uploads/scientific/big/';
            $pathMedium = 'assets/uploads/scientific/medium/';
            File::delete($pathBig . $scientific->image);
            File::delete($pathMedium . $scientific->image);
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        $scientific->where('id', $id)->update($input);


        return Redirect::action('Admin\ScientificController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(ScientificRequest $request)
    {
      /*  $images = Scientific::whereIn('id', $request->get('deleteId'))->get();
        foreach ($images as $item) {
           // File::delete('assets/uploads/scientific/big/' . $item);
           // File::delete('assets/uploads/scientific/medium/' . $item);
            $item->delete_temp = time();
            $item->save();
        }
*/
        Scientific::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);


        return Redirect::action('Admin\ScientificController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        
    }
}
