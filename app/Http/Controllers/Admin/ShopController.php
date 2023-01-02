<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ShopRequest;
use App\Models\AllotmentCategory;
use App\Models\Category;
use App\Models\ScientificCategory;
use App\Models\Shop;
use App\Models\ShopCustomerMsg;
use App\Models\ShopSubscription;
use App\User;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ShopController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Shop::with('user');

        //$query->whereStatus(1);


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
            if ($request->has('category')) {
                $query->where('category_id',  $request->get('category') );
            }

        }

        //dd($query);
        if (!$request->has('sort')) {
            $query->orderBy('id', 'DESC');
        }

        $data = $query->paginate(15);

        $category=AllotmentCategory::pluck('title','id')->toArray();

        return view('admin.shop.index')
            ->with('data', $data)
            ->with('category',$category);
    }

    public function getSubscriptionIndex(Request $request)
    {

        $query = ShopSubscription::with('user','shop');

        //$query->whereStatus(1);


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
            if ($request->has('category')) {
                $query->where('category_id',  $request->get('category') );
            }

        }

        //dd($query);
        if (!$request->has('sort')) {
            $query->orderBy('id', 'DESC');
        }

        $data = $query->paginate(15);

        $category=AllotmentCategory::pluck('title','id')->toArray();

        return view('admin.subscriptions.index')
            ->with('data', $data)
            ->with('category',$category);
    }

    public function getCustomerMsgIndex(Request $request)
    {

        $query = ShopCustomerMsg::with('user','shop');

        //$query->whereStatus(1);


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
            if ($request->has('category')) {
                $query->where('category_id',  $request->get('category') );
            }

        }

        //dd($query);
        if (!$request->has('sort')) {
            $query->orderBy('id', 'DESC');
        }

        $data = $query->paginate(15);

        $category=AllotmentCategory::pluck('title','id')->toArray();

        return view('admin.shopcustomermsg.index')
            ->with('data', $data)
            ->with('category',$category);
    }

    public function getCustomerMsgEdit($id)
    {
        $data = ShopCustomerMsg::find($id);
        $users=User::select('id','name')->where('id',$data->user_id)->pluck('name','id')->toArray();
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $shops=Shop::select('id','name')->pluck('name','id')->toArray();
        return view('admin.shopcustomermsg.edit')
            ->with('data', $data)->with('user', $users)->with('shop',$shops);

    }


    public function postCustomerMsgEdit($id, Request $request)
    {
        $input = $request->except('_token');

        $shop = ShopCustomerMsg::find($id);

        $shop->where('id', $id)->update($input);

        return Redirect::action('Admin\ShopController@getCustomerMsgIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

        
    }
    

    public function postCustomerMsgDelete(Request $request)
    {


        ShopCustomerMsg::whereIn('id', $request->get('deleteId'))->delete();

        return Redirect::action('Admin\ShopController@getCustomerMsgIndex')
            ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');


    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $category=AllotmentCategory::pluck('title','id')->toArray();
        return View('admin.shop.add')->with('status', $status)->with('category',$category);
    }
    public function getSubscriptionAdd()
    {
        $users=User::select('id','name')->pluck('name','id')->toArray();
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $shops=Shop::select('id','name')->pluck('name','id')->toArray();
        return view('admin.subscriptions.add')->with('user', $users)->with('shop',$shops);
    }

    public function postSubscriptionAdd(Request $request)
    {
        $input = $request->all();


        ShopSubscription::create($input);

        return Redirect::action('Admin\ShopController@getSubscriptionIndex')
            ->with('success', 'با موفقیت ثبت شد.');
    }

    public function getSubscriptionEdit($id)
    {
        $data = ShopSubscription::find($id);
        $users=User::select('id','name')->where('id',$data->user_id)->pluck('name','id')->toArray();
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $shops=Shop::select('id','name')->pluck('name','id')->toArray();
        return View('admin.subscriptions.edit')
            ->with('data', $data)->with('user', $users)->with('shop',$shops);

    }


    public function postSubscriptionEdit($id, Request $request)
    {
        $input = $request->except('_token');

        $shop = ShopSubscription::find($id);

        $shop->where('id', $id)->update($input);


        return Redirect::action('Admin\ShopController@getSubscriptionIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postAdd(ShopRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/shop/';
                $pathMain = 'assets/uploads/shop/main/';
                $pathBig = 'assets/uploads/shop/big/';
                $pathMedium = 'assets/uploads/shop/medium/';
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

        Shop::create($input);

        return Redirect::action('Admin\ShopController@getIndex')
            ->with('success', 'اخبار جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Shop::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $category=AllotmentCategory::pluck('title','id')->toArray();
        return View('admin.shop.edit')
            ->with('data', $data)->with('status', $status)->with('category',$category);

    }


    public function postEdit($id, ShopRequest $request)
    {
        $input = $request->except('_token');

        $shop = Shop::find($id);
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/shop/';
            $pathMain = 'assets/uploads/shop/main/';
            $pathBig = 'assets/uploads/shop/big/';
            $pathMedium = 'assets/uploads/shop/medium/';
            File::delete($pathBig . $shop->image);
            File::delete($pathMedium . $shop->image);
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
        $shop->where('id', $id)->update($input);


        return Redirect::action('Admin\ShopController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(ShopRequest $request)
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


        Shop::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);

        return Redirect::action('Admin\ShopController@getIndex')
            ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');


    }
    public function postSubscriptionDelete(Request $request)
    {


        ShopSubscription::whereIn('id', $request->get('deleteId'))->delete();

        return Redirect::action('Admin\ShopController@getSubscriptionIndex')
            ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');


    }
}
