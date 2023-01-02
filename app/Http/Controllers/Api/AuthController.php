<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


class AuthController extends Controller
{

    public function login()
    {
        $mobile=request('mobile');
        if(preg_match('/(09|9)([0-9]{9})/',$mobile,$match)){
            if($match[1]=='09'){
                $mobile='9'.$match[2];
            }
        }
        //dd(['mobile'=>$mobile,'password'=>request('password')]);
        $credentials = ['mobile'=>$mobile,'password'=>request('password'),'status'=>1];

//        return $credentials ;

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['success' => false,'message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {

            return response()->json(['success'=>true,'data'=>auth('api')->user()]);
    }


    public function logout()
    {

            auth('api')->logout();
            return response()->json(['success' => true,'message' => 'Logouted']);

    }

}
