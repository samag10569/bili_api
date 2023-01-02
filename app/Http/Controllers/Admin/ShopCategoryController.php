<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopCategory;
use Classes\MakeTree;
use Illuminate\Http\Request as RequestAlias;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ShopCategoryController extends Controller
{
    public function getIndex(RequestAlias $request)
    {
        $data = ShopCategory::orderBy('listorder', 'DESC');
        if ($request->has('search')) {

            if ($request->has('title')) {
                $data->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }
        }
        $data = $data->get()->toArray();

        if (!empty($data)) {
            MakeTree::getData($data);
            $data = MakeTree::GenerateArray(array('parent_id' => 0, 'paginate' => 15));
        }
        $all = ShopCategory::where('parent_id', 0)->orderBy('listorder', 'ASC')->get();
        return View('admin.shop-category.index')
            ->with('data', $data)->with('all', $all);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        $category = ShopCategory::all()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }

        $category = [0 => 'بدون والد'] + (array)$category;


        return View('admin.shop-category.add')->with('status', $status)
            ->with('category', $category);
    }


    public function postAdd(RequestAlias $request)
    {

        $shop_cat = ShopCategory::create($request->all());
        //event(new LogUserEvent($shop_cat->id, 'add', Auth::user()->id));

        return Redirect::action('Admin\ShopCategoryController@getIndex')
            ->with('success', 'مجموعه جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = ShopCategory::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $category = ShopCategory::where('id', '<>', $id)->get()->toArray();

        if (!empty($category)) {
            MakeTree::getData($category);
            $category = MakeTree::GenerateSelect(array('parent_id' => 0, 'separator' => ' -- '));
        }
        $category = [0 => 'بدون والد'] + (array)$category;


        return View('admin.shop-category.edit')
            ->with('data', $data)->with('status', $status)
            ->with('category', $category);
    }


    public function postEdit($id, RequestAlias $request)
    {

        $input = $request->except('_token');
        $row = ShopCategory::find($id);
        $row->where('id', $id)->update($input);
       // event(new LogUserEvent($row->id, 'edit', Auth::user()->id));
        return Redirect::action('Admin\ShopCategoryController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(RequestAlias $request)
    {
        
    //BUG!!!

       // ShopCategory::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);

        $ids = $request->all()['deleteId'];
        foreach ($ids as $id){
            $category = ShopCategory::findOrFail($id);
            $children = $category->children()->get()->toArray();
            foreach ($children as $child){
                $del_ids[] = ($child['id']);
            }
            $del_ids[] = intval($id);
        }

        ShopCategory::destroy($del_ids);


        return Redirect::action('Admin\ShopCategoryController@getIndex')
            ->with('success', 'مجموعه های مورد نظر با موفقیت حذف شدند.');


    }

    public function postSort(RequestAlias $request)
    {
        if ($request->get('update') == 'update') {
            $count = 1;
            foreach ($request->get('arrayorder') as $idval) {
                $sortList = ShopCategory::find($idval);
                $sortList->listorder = $count;
                $sortList->save();
                $count++;
            }
            return response()->json('با موفقیت ذخیره شد.');
        }
    }
}
