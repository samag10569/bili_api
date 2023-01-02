<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\AdsOrderCategoryRequest;
use App\Models\AdsOrderCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Classes\MakeTree;

class AdsOrderCategoryController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = AdsOrderCategory::query();

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

        $data = $query->get()->toArray();

        if (!empty($data)) {
            MakeTree::getData($data);
            $data = MakeTree::GenerateArray(array('parent_id' => 0, 'paginate' => 15));
        }

        $all = AdsOrderCategory::where('status', 1)->where('parent_id', 0)->orderBy('listorder', 'ASC')->get();
        return View('admin.adsorder-category.index')
            ->with('data', $data)->with('all', $all);
    }


    public function postAdd(AdsOrderCategoryRequest $request)
    {
        $allotment = AdsOrderCategory::create($request->all());
        event(new LogUserEvent($allotment->id, 'add', Auth::user()->id));

        return Redirect::action('Admin\AdsOrderCategoryController@getIndex')
            ->with('success', 'خدمت جدید با موفقیت ثبت شد.');
    }


    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        $category = AdsOrderCategory::all()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }

        $category = [0 => 'بدون والد'] + (array)$category;


        return View('admin.adsorder-category.add')->with('status', $status)
            ->with('category', $category);
    }



    public function getEdit($id)
    {
        $data = AdsOrderCategory::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        $category = AdsOrderCategory::where('id', '<>', $id)->get()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }
        $category = [0 => 'بدون والد'] + (array)$category;

        return View('admin.adsorder-category.edit')
            ->with('data', $data)->with('status', $status)
            ->with('category', $category);
    }


    public function postEdit($id, AdsOrderCategoryRequest $request)
    {

        $input = $request->except('_token');

        $ac = AdsOrderCategory::find($id);

        $ac->where('id', $id)->update($input);

        event(new LogUserEvent($ac->id, 'edit', Auth::user()->id));

        return Redirect::action('Admin\AdsOrderCategoryController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(AdsOrderCategoryRequest $request)
    {
        if (AdsOrderCategory::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\AdsOrderCategoryController@getIndex')
                ->with('success', 'خدمات مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function postSort(AdsOrderCategoryRequest $request)
    {
        if ($request->get('update') == 'update') {
            $count = 1;
            foreach ($request->get('arrayorder') as $idval) {
                $sortList = AdsOrderCategory::find($idval);
                $sortList->listorder = $count;
                $sortList->save();
                $count++;
            }
            return response()->json('با موفقیت ذخیره شد.');
        }
    }

}
