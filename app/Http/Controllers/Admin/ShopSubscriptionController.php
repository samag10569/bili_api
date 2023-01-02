<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\SubscriptionRequest;
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

class ShopSubscriptionController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = ShopSubscription::with('shop')->with('user')->whereNull('deleted_at');

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
                $querysearch = Shop::where('name','Like', '%' . $request->get('name') . '%')
                    ->pluck('id')->toArray();
                $query->whereIn('shop_id', $querysearch);
            }

        }

        //dd($query);
        if (!$request->has('sort')) {
            $query->orderBy('id', 'DESC');
        }

        $data = $query->paginate(15);



        return view('admin.subscription.index')
            ->with('data', $data);
    }
    public function postDelete(SubscriptionRequest $request)
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


        ShopSubscription::whereIn('id', $request->get('deleteId'))->update(['deleted_at' => time()]);

        return Redirect::action('Admin\ShopSubscriptionController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت حذف شدند.');


    }

}
