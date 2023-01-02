<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\ScientificCategoryRequest;
use App\Models\ScientificCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Classes\MakeTree;

class ScientificCategoryController extends Controller
{
    public function getIndex(Request $request)
    {

        $data = ScientificCategory::orderBy('listorder', 'DESC');

        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $data->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('title')) {
                $data->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }
        }
        $data = $data->get()->toArray();

        if (!empty($data)) {
            MakeTree::getData($data);
            $data = MakeTree::GenerateArray(array('parent_id' => 0, 'paginate' => 15));
        }

        $all = ScientificCategory::where('parent_id', 0)->orderBy('listorder', 'ASC')->get();
        return View('admin.scientific-category.index')
            ->with('data', $data)->with('all', $all);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        $category = ScientificCategory::all()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }

        $category = [0 => 'بدون والد'] + (array)$category;


        return View('admin.scientific-category.add')->with('status', $status)
            ->with('category', $category);
    }


    public function postAdd(ScientificCategoryRequest $request)
    {

        $scientific = ScientificCategory::create($request->all());
        event(new LogUserEvent($scientific->id, 'add', Auth::user()->id));

        return Redirect::action('Admin\ScientificCategoryController@getIndex')
            ->with('success', 'مجموعه جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = ScientificCategory::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $category = ScientificCategory::where('id', '<>', $id)->get()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }
        $category = [0 => 'بدون والد'] + (array)$category;


        return View('admin.scientific-category.edit')
            ->with('data', $data)->with('status', $status)
            ->with('category', $category);
    }


    public function postEdit($id, ScientificCategoryRequest $request)
    {

        $input = $request->except('_token');
        $row = ScientificCategory::find($id);
        $row->where('id', $id)->update($input);
        event(new LogUserEvent($row->id, 'edit', Auth::user()->id));
        return Redirect::action('Admin\ScientificCategoryController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(ScientificCategoryRequest $request)
    {
        //BUG!!!

        ScientificCategory::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);


            return Redirect::action('Admin\ScientificCategoryController@getIndex')
                ->with('success', 'مجموعه های مورد نظر با موفقیت حذف شدند.');
        
    }

    public function postSort(ScientificCategoryRequest $request)
    {
        if ($request->get('update') == 'update') {
            $count = 1;
            foreach ($request->get('arrayorder') as $idval) {
                $sortList = ScientificCategory::find($idval);
                $sortList->listorder = $count;
                $sortList->save();
                $count++;
            }
            return response()->json('با موفقیت ذخیره شد.');
        }
    }

}
