<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billboard;
use App\Models\FavoritProductUser;
use App\Models\ImageCompressModel;
use App\Models\Message;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\Shop;
use App\Models\ShopProductComment;
use App\Models\ShopProductImage;
use App\Models\ShopCustomer;
use App\Models\ShopCustomerCat;
use App\Models\ShopCustomerMsg;
use App\Models\ShopMsg;
use App\Models\ShopSubscription;
use App\Models\UserLog;
use App\User;
use Carbon\Carbon;
use Classes\Helper;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\classes\Resize;


class ShopController extends Controller
{
    public function __construct()
    {
//        header("Access-Control-Allow-Origin: *");

    }

    public function addShopProduct(Request $request)
    {


        $shop = Shop::query()
            ->where('user_id', Auth::user()->id)
            ->first();
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
//        if ($request->hasFile('image')) {
//            $file = $request->file('image');
//            $extension = $file->getClientOriginalExtension();
//            $ext = ['jpg', 'jpeg', 'png']; // other
//            $path = 'assets/uploads/products/';
//            if (in_array($extension, $ext)) {
//                $fileName = str_random(12) . md5(microtime()) . ".$extension";
//                $file->move($path, $fileName);
//                $input['image'] = $fileName;
//            }
//            else {
//                return response()->json(['success' => false, 'message' => 'فایل ارسالی صحیح نیست.']);
//            }
//        }

        unset($input['token']);
        Product::query()->create($input);
        return response()->json(['success' => true, 'message' => 'با موفقیت ثبت شد.']);

    }

    public function getAll(Request $request)
    {
        $data = Shop::query()->where('user_id', Auth::user()->id)->first();
        $data->shopCategory;


        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function getCustomers(Request $request)
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        if ($shop) {
            $data = ShopCustomer::where('shop_id', $shop->id)->get();

            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'data' => null, 'message' => __('no store registered for you')]);
    }

    public function getCustomersCats(Request $request)
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();

        if ($shop) {
            $data = ShopCustomerCat::where('shop_id', $shop->id)->get();
            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'msg' => 'NoShop']);
    }

    public function getShopMsgs(Request $request)
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        if ($shop) {
            $data = ShopMsg::where('shop_id', $shop->id)->get();

            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['success' => false, 'msg' => 'NoShop']);
    }

    public function addCustomerCat(Request $request)
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();

        if ($shop) {
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
        return response()->json(['success' => false, 'msg' => __("NoShop")]);
    }

    public function addCustomerMsg(Request $request)
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();

        if ($shop) {
            $validator = Validator::make($request->all(), [
                'user' => 'required',
                'content' => 'required|string|max:1000|min:5',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success' => false, 'errors' => $errors]);
            }

            $user = ShopCustomer::query()->where('shop_id', $shop->id)
                ->where('user_id', $request->user)
                ->first();

            if (!$user) {
                return response()->json(['success' => false, 'msg' => 'NoUser']);
            }
            $input = $request->only([
                'content'
            ]);

            $input['shop_id'] = $shop->id;
            $input['user_id'] = $request->get('user');

            ShopCustomerMsg::query()->create($input);

            return response()->json(['success' => true, 'msg' => 'Ok']);
        }
        return response()->json(['success' => false, 'msg' => 'NoShop']);

    }

    public function updateShop(Request $request)
    {
        $shop = Shop::query()->where('user_id', Auth::user()->id)->first();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        $input = $request->only([
            'name', 'category_id', 'content', 'address', 'lat', 'lng'
        ]);


        $input['user_id'] = Auth::user()->id;
        if (!$shop) {
            Shop::create($input);
            return response()->json(['success' => true, 'msg' => __("ShopCreated")]);
        }

//  ---- for edit -----//
//        Shop::where('id', $shop->id)->update($input);
        $data = Shop::query()->where('id', $shop->id)->first();
        $data->name = $request->name;
        $data->category_id = $request->category_id;
        $data->content = $request->content;
        $data->address = $request->address;
        $data->lat = $request->lat;
        $data->lng = $request->lng;
        if ($request->hasFile('image')) {
            $path =  $data->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $cover = $request->file('image');
            $filename = time() . '_' . $cover->getClientOriginalName();
            $path ='assets/uploads/shop/';
            $fullPath ='http://127.0.0.1:8080/assets/uploads/shop/';
            $cover->move($path, $filename);
            $end=$path.$filename;
            //------- compress ------//
            $comp = new ImageCompressModel();
            $comp->setImage($end);//Image to use
            $comImg= $comp->compress();
            $data->image = $comImg;
            //------- resize -------//
            $resizeObj = new Resize($comImg);
// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
            $resizeObj -> resizeImage(150, 100, 'auto');
// *** 3) Save image
            // $save = 'assets/uploads/shop/'.rand(1245.6542).'.jpg';
            $saveImg= 'assets/uploads/shop/'."thumbnail".$filename;
//           $resizeObj -> saveImage("assets/uploads/shop/1609242433_shop.jpg", 100);
            $resizeObj -> saveImage($saveImg, 100);
            $data->thumbnail=$saveImg;

        }
        $data->save();
        return response()->json([
            'success' => true,
            'msg' => __("ShopUpdated"),
            'data' => $data,

        ]);

    }



    public function setSubscription(Request $request)
    {
        $exist = DB::table('shop_subscription')
            ->where('user_id', Auth::user()->id)
            ->where('shop_id', $request->get('shop_id'))
            ->count();
        if (!$exist) {
            DB::table('shop_subscription')
                ->insert([
                    'user_id' => Auth::user()->id,
                    'shop_id' => $request->get('shop_id'),
                    'created_at' => Carbon::now()->timestamp
                ]);
        }
        return response()->json(['success' => true, 'msg' => 'ok']);
    }

    public function getSubscription($id)
    {
//        $data = ShopSubscription::with('shop')
//            ->where('user_id', Auth::user()->id)
//            ->limit(10)
//            ->get();
        $followers = ShopSubscription::query()->where('shop_id', $id)->count();

//        $shop = Auth::user()->shop ;
//        $followers = ShopSubscription::query()->where('shop_id',$shop->id)->count();
        $shop = Shop::query()->select('user_id')->find($id);
        $user_id = $shop->user_id;
        $following = ShopSubscription::query()->where('user_id', $user_id)->count();
        return response()->json([
            'success' => true,
            'followers' => $followers,
            'following' => $following
        ]);
    }

    public function getSubscriptionOwn()
    {
        $following = ShopSubscription::with('shop')
            ->where('user_id', Auth::user()->id)
            ->count();
        $shop = Auth::user()->shop ;
        $followers = ShopSubscription::query()->where('shop_id',$shop->id)->count();
        return response()->json([
            'success' => true,
            'followers' => $followers,
            'following' => $following
        ]);
    }

    public function showFollowersOwn()
    {
        $followers= ShopSubscription::query()
            ->where('shop_id', \auth()->user()->shop->id)
            ->with('user')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $followers,
        ]);
    }

    public function searchSubscrib(Request $request)
    {
        $users = User::query()
//            ->whereRaw("concat(name, ' ', family) like '%" . $request->get('search') . "%' ")
            ->where("name" ,'like', '%'.$request->get('search').'%' )
            ->take(10)
            ->get() ;
        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }
    public function removeSubscription(Request $request)
    {
        $data = ShopSubscription::where('user_id', Auth::user()->id)
            ->where('shop_id', $request->get('shop_id'))
            ->delete();

        return response()->json(['success' => true, 'msg' => 'ok']);
    }

    public function addCustomer(Request $request)
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();
//            return Response()->json($shop);
//        TODO CHANGE MOBILE
//        TODO CHANGE MOBILE

        if ($shop) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'mobile' => 'required|regex:/(9)[0-9]{9}/|digits:11',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success' => false, 'errors' => $errors]);
            }
            $user = User::where('mobile', substr($request->get('mobile'), 1))->first();
            if (!$user) {
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

//=======================================  S.Golparvari  =================================//
    public function show_list_shop()
    {

        $data = shop::all();
//            $data = Shop::query()->where('user_id','<>',\auth()->user()->id)->get();
        foreach ($data as $item) {
            $shopId = $item->id;
            $userId = auth()->user()->id;
            $userIsSubcription = ShopSubscription::where('user_id', $userId)
                ->where('shop_id', $shopId)
                ->first();

            if ($userIsSubcription) {
                $item->userIsSubscription = true;
            } else {
                $item->userIsSubscription = false;
            }
        }
        return response()->json(['success' => true, 'data' => $data]);

    }

    public function searchListShop(Request $request)
    {
        $data = Shop::query()->where('user_id', '<>', auth()->user()->id)
            ->where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function show_shop(Request $request, $id = 0)
    {

        $shop = shop::query()->find($id);
        $products=$shop->products;
        $shopId = $shop->id;
        $user_id = Auth::user()->id;

        $userIsSubcription = ShopSubscription::query()->where('user_id', $user_id)
            ->where('shop_id', $shopId)
            ->first();

        if ($userIsSubcription) {
            $shop->userIsSubscription = true;
        } else {
            $shop->userIsSubscription = false;
        }

        $followers = ShopSubscription::query()->where('shop_id', $id)->count();
        $following = ShopSubscription::query()->where('user_id', $user_id)->count();
        $countPost=shop::query()->find($id)->products->count();
        return response()->json([
            'success' => true,
            'data' => $shop,
            'followers' => $followers,
            'following' => $following,
            'countPost' => $countPost,
            'products' => $products,

        ]);

    }




    public function getShopProducts(Request $request)
    {
        $shop = Shop::query()
            ->where('user_id', Auth::user()->id)
            ->first();
//        $shop = Shop::where('id', $request->shop_id)->first();
        $data = $shop->products;

//        return \response()->json($data) ;
        foreach ($data as $item) {
            $commentsCount = ShopProductComment::query()
                ->where('product_id', $item->id)
                ->count();
            $item->comments_count = $commentsCount;

            $isLike = ProductUser::query()
                ->where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)
                ->first();

            $likeCount = ProductUser::query()->where('product_id', $item->id)->count();
            if ($isLike) {
                $item->is_like = 1;
                $item->like_counts = $likeCount ?? 0;
            } else {
                $item->is_like = 0;
                $item->like_counts = $likeCount ?? 0;
            }
            $isFavorite = FavoritProductUser::query()
                ->where('user_id',auth()->user()->id)
                ->where('product_id',$item->id)
                ->first();
//            return Response()->json($isFavorite);

            if ($isFavorite) {
                $item->is_favorite = 1;
            } else {
                $item->is_favorite = 0;
            }
            $timeAgo = Carbon::parse($item->created_at);
            $timeNow = Carbon::now();
            $time = $timeNow->diffForHumans($timeAgo);


            $newExplodedTime = explode(' ' ,$time) ;
            if (count($newExplodedTime) > 2){
                $newTimeString = $newExplodedTime[0] . ' ' . $newExplodedTime[1] . ' پیش' ;
            }else{
                $newTimeString = $time ;
            }
            $item->time = $newTimeString ;
            $item->shop;
        }
        return response()->json([
            'success' => true ,
            'shop'=>$shop ,
            'data' => $data ,
        ]);

    }



    public function HomeInfo(Request $request)
    {
        $shops=Shop::all();

        $user= \auth()->user();
        $user_id=$user->id;
        $shopOwn = Shop::query()
            ->where('user_id', $user_id)
            ->first();
        $productsOwn=$shopOwn->products;

        header('Content-type: application/json');
        $req = new Request();
        $ownProducts = $this->getShopProducts($req) ;
        $ownProducts = json_encode($ownProducts)  ;
        $ownProducts = json_decode($ownProducts)  ;
        $orginalOwnProducts = $ownProducts->original ;
        $ownProducts = $orginalOwnProducts->shop->products ;

        $shopSubscribs = ShopSubscription::query()
            ->where('user_id',$user_id)
            ->with('shop')
            ->get();
        $shopSubscribArray = [] ;

        foreach ($shopSubscribs as $shopSubscrib){
            $shopSubscribProducts =  $shopSubscrib->shop->products ;
            foreach ($shopSubscribProducts as $shopSubscribProduct){
                $shopSubscribArray[]=$shopSubscribProduct ;


            }
        }

        foreach ($shopSubscribArray as $item) {
            $commentsCount = ShopProductComment::query()
                ->where('product_id', $item->id)
                ->count();
            $item->comments_count = $commentsCount;

            $isLike = ProductUser::query()
                ->where('user_id', Auth::user()->id)
                ->where('product_id', $item->id)
                ->first();

            $likeCount = ProductUser::query()->where('product_id', $item->id)->count();
            if ($isLike) {
                $item->is_like = 1;
                $item->like_counts = $likeCount ?? 0;
            } else {
                $item->is_like = 0;
                $item->like_counts = $likeCount ?? 0;
            }
            $isFavorite = FavoritProductUser::query()
                ->where('user_id',auth()->user()->id)
                ->where('product_id',$item->id)
                ->first();
//            return Response()->json($isFavorite);

            if ($isFavorite) {
                $item->is_favorite = 1;
            } else {
                $item->is_favorite = 0;
            }
            $timeAgo = Carbon::parse($item->created_at);
            $timeNow = Carbon::now();
            $time = $timeNow->diffForHumans($timeAgo);


            $newExplodedTime = explode(' ' ,$time) ;
            if (count($newExplodedTime) > 2){
                $newTimeString = $newExplodedTime[0] . ' ' . $newExplodedTime[1] . ' پیش' ;
            }else{
                $newTimeString = $time ;
            }
            $item->time = $newTimeString ;
            $item->shop;

        }

        $merged_array = array_merge($ownProducts,$shopSubscribArray);
        $col  = 'id';
        $sort = array();
        foreach ($merged_array as $i => $obj) {
            $sort[$i] = $obj->{$col};
        }
        $sorted_db = array_multisort($sort, SORT_DESC, $merged_array);

//        $sorted =  $this->array_orderby($merged_array, 'id', SORT_DESC);

        return response()->json([
            'success'=>true,
            'user'=>$user,
            'shopOwn'=> $shopOwn,
            'shopSubscribs'=> $shopSubscribs,
            'mergedProducts'=>$merged_array,
            'ownProducts'=> $ownProducts,
            '$shopSubscribProducts'=> $shopSubscribArray,
            'allShops'=> $shops,

        ],200);

    }






    public function getSingleProduct($id)
    {
        $product=Product::query()->find($id);
        $commentsCount=ShopProductComment::query()->where('product_id',$product->id)->count();
        $product->comments_count = $commentsCount;
        $isLike = ProductUser::query()->where('user_id', Auth::user()->id)
            ->where('product_id', $product->id)->first();
        $likeCount = ProductUser::query()->where('product_id', $product->id)->count();
        if ($isLike) {
            $product->is_like = 1;
            $product->like_counts = $likeCount ?? 0;
        } else {
            $product->is_like = 0;
            $product->like_counts = $likeCount ?? 0;
        }
        $timeAgo = Carbon::parse($product->created_at);
        $timeNow = Carbon::now();
        $time = $timeNow->diffForHumans($timeAgo);


        $newExplodedTime = explode(' ' ,$time) ;
        if (count($newExplodedTime) > 2){
            $newTimeString = $newExplodedTime[0] . ' ' . $newExplodedTime[1] . ' پیش' ;
        }else{
            $newTimeString = $time ;
        }
        $product->time = $newTimeString ;
        $product->shop;

        return response()->json([
            'success' => true,
            'data' => $product,
        ]);

    }

    public function productsShop($id)
    {
        $products = Product::query()->where('shop_id', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $products,

        ]);
    }

    public function getShopProduct($id)
    {
        $data = Product::find($id);
//      return Respons()->json($shop);
        return response()->json(['success' => true, 'data' => $data]);

    }

//    public function resizeImageDropzonProduct(){
//        $this->validate($request, [
//            'title' => 'required',
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
//
//        $image = $request->file('image');
//        $input['imagename'] = time().'.'.$image->extension();
//
//        $destinationPath = public_path('/thumbnail');
//        $img = Image::make($image->path());
//        $img->resize(100, 100, function ($constraint) {
//            $constraint->aspectRatio();
//        })->save($destinationPath.'/'.$input['imagename']);
//
//        $destinationPath = public_path('/images');
//        $image->move($destinationPath, $input['imagename']);
//
//        return back()
//            ->with('success','Image Upload successful')
//            ->with('imageName',$input['imagename']);
//    }
//
//    }


    public function imagesDropzone(Request $request)
    {
//        return response()->json([
//            'success' => true,
//            'product_id' => 10,
//            'data' => $request->get('product_id')
//        ]);
        $shop = Shop::query()->where('user_id', Auth::user()->id)->first();


        if ($request->has('product_id')
            && $request->get('product_id') != ''
            && $request->get('product_id') != 0 ){
            $productId = $request->get('product_id') ;
        }else{
            $product = new Product();
            $product->name = '';
            $product->price = '0';
            $product->content = '';
            $product->cat_id = '0';
            $product->discount = '0';
//        $product->  expired_at ='';
            $product->shop_id = $shop->id;

            $product->save();
            $productId = $product->id ;
        }
        $cover = $request->file('file');
        $data = new ShopProductImage();

//        return Response()->json($request->all());
        $filename = time() . '_' . $cover->getClientOriginalName();
        $path = 'assets/uploads/products/';
        $cover->move($path, $filename);
        $end=$path.$filename;
        $data->filename = $end;
        $data->shop_id = $shop->id;
        $data->product_id = $productId;
        $data->save();


        return response()->json([
            'success' => true,
            'product_id' => $productId,
            'data' => $data
        ]);
    }

    public function removeDropzone(Request $request){

        return response()->json($request->all());

    }

    public function editShopProduct(Request $request, $id)
    {

        $shop = Shop::query()
            ->where('user_id', Auth::user()->id)
            ->first();
//        return Response()->json($shop);
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


        $data = Product::find($id);
//        return Response()->json($data);

        $data->name = $request->name;
        $data->content = $request->get('content');
        $data->price = $request->price;
        $data->discount = $request->discount;
        $data->expired_at = $request->expired_at;
        $data->cat_id = $request->cat_id;


        if ($request->hasFile('image')) {
            $path =  $data->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $cover = $request->file('image');
            $filename = time() . '_' . $cover->getClientOriginalName();
            $path = 'assets/uploads/products/';
            $cover->move($path, $filename);
            $end= $path.$filename;
//            ------------------------------------//
            $comp = new ImageCompressModel();
            $comp->setImage($end);//Image to use
            $comImg= $comp->compress();
//            echo $comp->getSize();
//            exit;
//            -----------------------------------//
            $data->image = $comImg
            ;
        }
        unset($input['token']);
        $data->save();
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => __('product successfuly updated')
        ]);
    }


    public function ShopProductComment(Request $request, $id)
    {
        //        $product_id=Product::where('id',$id)->get();
        $data = new ShopProductComment();
        $data->user_id = auth()->user()->id;
        $data->product_id = $id;
//        $data->parent_id = $request->get('shop_product_comment_id') ?? 0 ;
        $data->parent_id = $request->get('parent_id') ?? 0;
        $data->content = $request->get('content') ?? '';
        $data->save();

        $user = Auth::user();
        $user_id = $user->id;
        $product_id =  $id;
//        return Response()->json($product_id);

        $comment = ShopProductComment::query()
            ->where('product_id',$product_id)
            ->first();
//        $comment = ShopProductComment::query()

//            ->find($product_id);
        $user_owner_id=$comment->product->shop->user->id;
        $product= $comment->product;
//        return Response()->json($comment->product->shop->user->id);
        $activity = new UserLog();
        $activity->user_executor_id = $user_id;
        $activity->user_owner_id = $user_owner_id;
        $activity->activities_type = 5;
        $activity->log_text = "برای محصول " . $product->name . " توسط " . $user->name . "  نظر ثبت شد ";
        $activity->user_logable_id = $product_id;
        $activity->user_logable_type = get_class($comment);
        $activity->save();

        return response()->json([
            'message'=> __( "successfully registered" ),
            'success' => true,
            'activity' => $activity,
            'data' => $data,
        ]);

    }

    public function getProductComments($id)
    {
        $data = ShopProductComment::query()
            ->where('product_id', $id)
            ->where('parent_id','0')
//            ->get();
            ->orderBy('id','desc')->get();

        foreach ($data as $item) {
            $user = User::query()->find($item->user_id);
            $item->user = $user;
            $item->children;
        }
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);

    }

    public function getFavorite()
    {
        $favorite = FavoritProductUser::select('favorit_product_users.*', 'products.image', 'products.name')
            ->where('user_id', auth()->user()->id)
            ->join('products', 'products.id', 'favorit_product_users.product_id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $favorite,
        ]);
    }

    public function createIdProduct(Request $request)
    {
        $shop= Shop::query()
            ->where('user_id',\auth()->user()->id)
            ->first();
        $shopId=$shop->id;
//        return \response()->json($shopId);
        $product= new Product();
        $product->shop_id = $shopId;
//        return \response()->json($product);
        $product->name = $request->name ?? "";
        $product->content = $request->get('content') ?? "";
        $product->price = $request->price ?? 0;
        $product->discount = $request->discount ?? 0;
        $product->expired_at = $request->expired_at ?? 0;
        $product->cat_id = $request->cat_id ?? 1;
        $product->save();
        return response()->json([
            'success' => true,
            'data' => $product,
        ]);
    }



    public function upload_image (Request $request,$id)
    {
        return \response()->json($request->all());


        $shop= Shop::query()
            ->where('user_id',\auth()->user()->id)->first();
        $product= Product::query()->find($id);
        $productId= $product->id;
//        return response()->json($productId);
        $img = new ShopProductImage();
        $cover = $request->file('filename');
        $filename = time() . '_' . $cover->getClientOriginalName();
        $path = 'assets/uploads/products/';
        $cover->move($path, $filename);
        $end= $path.$filename;

        $img->filename = $end;
        $img->shop_id = $shop->id;
        $img->product_id = $productId;
        $img->save();


        return response()->json([
            'success' => true,
            'product_id' => $productId,
            'data' => $img
        ]);
    }


    public  function fetch_image(Request $request,$id)
    {
        $productImages = ShopProductImage::query()
            ->where('product_id',$id)
            ->get() ;


        $output = '';
        foreach($productImages as $image)
        {
            $imageDiv =
                `<div class="dz-preview dz-processing dz-image-preview dz-complete">
            <div class="dz-image">
                <img data-dz-thumbnail="" alt="a2.jpg" src="http://localhost:8000/bilimob/images/s1.jpg">
            </div>
            <div class="dz-details">
                <div class="dz-size">
                    <span data-dz-size="">
                        <strong>10.4</strong> KB
                    </span>
                </div>
                <div class="dz-filename">
                    <span data-dz-name="">a2.jpg</span>
                </div>
            </div>

            <div class="dz-progress">
                <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
            </div>

            <div class="dz-error-message">
                <span data-dz-errormessage=""></span>
            </div>

            <div class="dz-success-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>Check</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF">
                        </path>
                    </g>
                </svg>
            </div>

            <div class="dz-error-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>Error</title>
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                            <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z">
                            </path>
                        </g>
                    </g>
                </svg>
            </div>
            <a class="dz-remove" data-id="10" href="javascript:undefined;" data-dz-remove="">حذف عکس</a>
            </div>`;


            $output .= $imageDiv ;
        }

        echo $output;
    }


    public function delete_image(Request $request,$id)
    {
        $productImage = ShopProductImage::query()
            ->where('id',$id)
            ->first() ;

        $fileName = $productImage -> filename ?? '' ;
        $productImage->delete() ;


        try {
            File::delete(public_path( $fileName));


            return \response()->json([
                'success' => 'true' ,
                'message' => __('file successfully removed')
            ],200) ;

        }catch (\Exception $exception){

            return \response()->json([
                'success' => 'failed' ,
                'message' => __('ops . somethings goes wrong')
            ],200) ;
        }


    }








}
