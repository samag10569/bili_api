<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ScientificCategory;
use App\Models\Shop;
use App\Models\ShopSubscription;
use App\User;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Product::with('shop')->whereNull('delete_temp');

        //$query->whereStatus(1);


        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('title')) {
                $query->where('name', 'LIKE', '%' . $request->get('title') . '%');
            }

        }

        //dd($query);
        if (!$request->has('sort')) {
            $query->orderBy('id', 'DESC');
        }

        $data = $query->paginate(15);



        return view('admin.product.index')
            ->with('data', $data);
    }

    public function getAdd()
    {

        $category=ScientificCategory::pluck('title','id')->toArray();
        $shop_id = Shop::pluck('name', 'id')->toArray();
        $shop_id = ['' => 'انتخاب کنید . . .'] + $shop_id;
        return View('admin.product.add')->with('category',$category)->with('shop',$shop_id);
    }

    public function postAdd(ProductRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/product/';
                $pathMain = 'assets/uploads/product/main/';
                $pathBig = 'assets/uploads/product/big/';
                $pathMedium = 'assets/uploads/product/medium/';
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
            }
        }

        Product::create($input);

        return Redirect::action('Admin\ProductController@getIndex')
            ->with('success', 'محصول جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Product::find($id);

        $category=ScientificCategory::pluck('title','id')->toArray();
        $shop_id = Shop::pluck('name', 'id')->toArray();
        $shop_id = ['' => 'انتخاب کنید . . .'] + $shop_id;
        return View('admin.product.edit')
            ->with('data', $data)->with('category',$category)->with('shop',$shop_id);

    }


    public function postEdit($id, ProductRequest $request)
    {
        $input = $request->except('_token');

        $product = Product::find($id);
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/product/';
            $pathMain = 'assets/uploads/product/main/';
            $pathBig = 'assets/uploads/product/big/';
            $pathMedium = 'assets/uploads/product/medium/';
            File::delete($pathBig . $product->image);
            File::delete($pathMedium . $product->image);
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
        $product->where('id', $id)->update($input);


        return Redirect::action('Admin\ProductController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(ProductRequest $request)
    {
        /* $images = Shop::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
         foreach ($images as $item) {
             File::delete('assets/uploads/shop/big/' . $item);
             File::delete('assets/uploads/shop/medium/' . $item);
         }
         if (Shop::destroy($request->get('deleteId'))) {
             return Redirect::action('Admin\ShopController@getIndex')
                 ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
         } */


        Product::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);

        return Redirect::action('Admin\ProductController@getIndex')
            ->with('success', 'محصولات مورد نظر با موفقیت حذف شدند.');


    }
}
