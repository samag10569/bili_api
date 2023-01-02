<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Category::query();
        $query->whereStatus(1);

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
        }

        $data = $query->paginate(15);

        $all = Category::where('status', 1)->orderBy('listorder', 'ASC')->get();
        return View('admin.category.index')
            ->with('data', $data)->with('all', $all);
    }


    public function postAdd(CategoryRequest $request)
    {
        $input = $request->all();

        $input['status'] = 1;

        Category::create($input);

        return Redirect::action('Admin\CategoryController@getIndex')
            ->with('success', 'ظرفیت ثبت نام جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Category::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.category.edit')
            ->with('data', $data)->with('status', $status);
    }


    public function postEdit($id, CategoryRequest $request)
    {

        $input = $request->except('_token');

        $news = Category::find($id);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\CategoryController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(CategoryRequest $request)
    {
        if (Category::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\CategoryController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function postSort(CategoryRequest $request)
    {
        if ($request->get('update') == "update") {
            $count = 1;
            if ($request->get('update') == 'update') {
                foreach ($request->get('arrayorder') as $idval) {
                    $sortList = Category::find($idval);
                    $sortList->listorder = $count;
                    $sortList->save();
                    $count++;
                }
                echo 'با موفقیت ذخیره شد.';
            }

        }

    }

}
