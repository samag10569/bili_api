<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billboard;
use App\Models\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Tymon\JWTAuth\Facades\JWTAuth;

class BillboardController extends Controller
{
    public function getAll(Request $request){
        $billboards=Billboard::with('image')->get();

        return response()->json(['success'=>true,'data'=>$billboards]);
    }

}
