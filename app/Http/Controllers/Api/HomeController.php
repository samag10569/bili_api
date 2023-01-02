<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Billboard;
use App\Models\Message;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\ShopCustomer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    public function getBanners(Request $request){
        $data=Banner::where('platform',2)
            ->where('status',1)
            ->get();

        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function getCats(Request $request){
        $main=ShopCategory::where('parent_id',0)
            ->where('status',1)
            ->get();

        $childs=ShopCategory::where('parent_id','<>',0)
            ->where('status',1)
            ->get();

        return response()->json(['success'=>true,'data'=>['main'=>$main,'childs'=>$childs]]);
    }



}
