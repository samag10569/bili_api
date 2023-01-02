<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billboard;
use App\Models\Message;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopCustomer;
use App\Models\ShopCustomerCat;
use App\Models\ShopCustomerMsg;
use App\Models\ShopMsg;
use App\Models\ShopSubscription;
use App\User;
use Carbon\Carbon;
use Classes\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShopController extends Controller
{
    public function addShopProduct(Request $request){




        $shop=Shop::where('user_id',Auth::user()->id)->first();
        $input = $request->except('_token');
        $input['shop_id'] = $shop->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png']; // other
            $path = 'assets/uploads/products/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['image'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

        unset($input['token']) ;
        Product::create($input);
        return response()->json(['success'=>true,'message'=>'با موفقیت ثبت شد.']);

    }
    public function getAll(Request $request){
        $data=Shop::where('user_id',Auth::user()->id)->first();

        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function getCustomers(Request $request){
        $shop=Shop::where('user_id',Auth::user()->id)->first();
        if($shop) {
            $data = ShopCustomer::where('shop_id', $shop->id)->get();

            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'data' => null]);
    }

    public function getCustomersCats(Request $request){
        $shop = Shop::where('user_id',Auth::user()->id)->first() ;
        if($shop) {
            $data = ShopCustomerCat::where('shop_id', $shop->id)->get() ;
            return response()->json(['success' => true, 'data' => $data]) ;
        }
        return response()->json(['success' => false, 'msg' => 'NoShop']) ;
    }

    public function getShopMsgs(Request $request){
        $shop=Shop::where('user_id',Auth::user()->id)->first();
        if($shop) {
            $data = ShopMsg::where('shop_id', $shop->id)->get();

            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'msg' => 'NoShop']);
    }

    public function addCustomerCat(Request $request){
        $shop=Shop::where('user_id',Auth::user()->id)->first();

        if($shop) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success' => false, 'errors' => $errors]);
            }
            $input = $request->only([
                'name'
            ]);

            $input['shop_id'] = $shop->id;

            ShopCustomerCat::create($input);

            return response()->json(['success' => true, 'msg' => 'Ok']);
        }
        return response()->json(['success' => false, 'msg' => 'NoShop']);

    }

    public function addCustomerMsg(Request $request){
        $shop=Shop::where('user_id',Auth::user()->id)->first();

        if($shop) {
            $validator = Validator::make($request->all(), [
                'user' => 'required',
                'content' => 'required|string|max:1000|min:5',
            ]) ;

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success' => false, 'errors' => $errors]) ;
            }

            $user = ShopCustomer::where('shop_id',$shop->id)
                ->where('user_id',$request->user)
                ->first() ;

            if(!$user){
                return response()->json(['success' => false, 'msg' => 'NoUser']) ;
            }
            $input = $request->only([
                'content'
            ]) ;

            $input['shop_id'] = $shop->id ;
            $input['user_id'] = $request->get('user') ;

            ShopCustomerMsg::create($input) ;

            return response()->json(['success' => true, 'msg' => 'Ok']) ;
        }
        return response()->json(['success' => false, 'msg' => 'NoShop']) ;

    }

    public function updateShop(Request $request){
        $shop=Shop::where('user_id',Auth::user()->id)->first() ;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]) ;
        if ($validator->fails()) {
            $errors = $validator->errors() ;
            return response()->json(['success' => false, 'errors' => $errors]) ;
        }
        $input = $request->only([
            'name', 'category_id','content','address','lat','lng'
        ]) ;


        $input['user_id'] = Auth::user()->id ;
        if(!$shop) {
            Shop::create($input);
            return response()->json(['success' => true, 'msg' => 'ShopCreated']);
        }

        Shop::where('id',$shop->id)->update($input);
        return response()->json(['success' => true, 'msg' => 'ShopUpdated']);

    }

    public function  setSubscription(Request $request){
        $exist=DB::table('shop_subscription')
            ->where('user_id',Auth::user()->id)
            ->where('shop_id',$request->get('shop_id'))
            ->count();
        if(!$exist){
            DB::table('shop_subscription')
                ->insert([
                    'user_id'=>Auth::user()->id,
                    'shop_id'=>$request->get('shop_id'),
                    'created_at'=>Carbon::now()->timestamp
                ]);
        }
        return response()->json(['success' => true, 'msg' => 'ok']);
    }

    public function  getSubscription(Request $request){
        $data=ShopSubscription::with('shop')
            ->where('user_id',Auth::user()->id)
        ->limit(10)
        ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function  removeSubscription(Request $request){
        $data=ShopSubscription::where('user_id',Auth::user()->id)
            ->where('shop_id',$request->get('shop_id'))
            ->delete();

        return response()->json(['success' => true, 'msg' => 'ok']);
    }

    public function addCustomer(Request $request){
        $shop = Shop::where('user_id',Auth::user()->id)->first() ;

//        TODO CHANGE MOBILE
//        TODO CHANGE MOBILE

        if($shop) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'mobile' => 'required|regex:/(9)[0-9]{9}/|digits:11',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success' => false, 'errors' => $errors]);
            }
            $user=User::where('mobile',substr($request->get('mobile'), 1))->first();
            if(!$user){
                return response()->json(['success' => false, 'msg' => 'UserNotFound']);
            }
            $input = $request->only([
                'name', 'mobile'
            ]);

            $input['shop_id'] = $shop->id;
            $input['user_id'] = $user->id;

            ShopCustomer::create($input);

            return response()->json(['success' => true, 'msg' => 'Ok']);
        }
        return response()->json(['success' => false, 'msg' => 'NoShop']);
    }

}
