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

class ScientificUsersController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Scientific::query();
        $query->where('isadmin',0);

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

        $data = $query->paginate(15);

        $category = ScientificCategory::get()->toArray();
        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }
        $category=['' => 'همه'] + (array) $category;
        return View('admin.scientific-users.index')
            ->with('data', $data)
            ->with('category',$category);
    }

    public function getEdit($id)
    {
        $data = Scientific::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $category = ScientificCategory::where('status',1)->get()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id'=>0,'separator'=>' -- '));
        }

        return View('admin.scientific-users.edit')
            ->with('data', $data)->with('status', $status)
            ->with('category',$category);

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


        return Redirect::action('Admin\ScientificUsersController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد!');

    }
}
