<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Dasteh;
use App\Models\Gerayesh;
use App\Models\Reshteh;
use App\Models\Shakheh;
use App\Models\State;
use App\Models\Tahsili;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Larabookir\Gateway\Gateway;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{
    public function Getphonenumber(Request $request)
    {
        if($request->has('mobile')){
            if(preg_match('/09([0-9]{9})/',$request->get('mobile'),$match)){
                $request->merge(['mobile'=>'9'.$match[1]]) ;
            }
        }

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|regex:/(9)[0-9]{9}/|digits:10|unique:users',
            //'name' => 'required|string|max:255',
        ]) ;

        if ($validator->fails()) {
        $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]) ;
        }

        $phonenumber = $request->input('mobile') ;
        $name = $request->input('name') ;
        $random_number = mt_rand(10000, 99999) ;
        $now = Carbon::now('Asia/Tehran')->timestamp ;
        $mobile = DB::table('users')->where('mobile', $phonenumber)->get()->first() ;

        if (!$mobile) {
            DB::table('users')->insert(
                ['mobile' => $phonenumber, 'sms_code' => $random_number, 'verified' => 0, 'updated_at' => $now,
                    'status'=>0,
                    'created_at' => $now]
            );
            //Smsirlaravel::send([$random_number], [$phonenumber]);
        } else {
            if ($now->diffInMinutes($mobile->updated_at) <= 2 || $now->diffInMinutes($mobile->updated_at) >= 5) {
                return response()->json(['success' => false, 'message' => 'NoGoodTime']);
            } else {
                DB::table('users')
                    ->where('mobile', $phonenumber)
                    ->update(['sms_code' => $random_number, 'updated_at' => $now,
                        'status'=>0,
                        'created_at' => $now]);
                //Smsirlaravel::send([$random_number], [$phonenumber]);
            }
        }
        return response()->json(['success' => true, 'message' => 'CodeSent', 'name' => $name]);
    }

    public function getTransactions(){
        $user=Auth::user();
        $data=['credit'=>$user->credit];
        $data['trans'] = DB::table('user_transactions')->where('user_id', $user->id)->get();
        return response()->json(['success' => true, 'data' => $data]);
    }


    public function Verifiphonenumber(Request $request)
    {
        $validator = Validator::make( $request->all() ,[
//            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11',
            'code' => 'required|digits:5',
            //'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if($request->has('mobile')){
            if(preg_match('/09([0-9]{9})/',$request->get('mobile'),$match)){
                $request->merge(['mobile'=>'9'.$match[1]]);
            }
        }

        $received = (int)$request->input('code');
        $phonenumber = $request->input('mobile');
        $code = DB::table('users')
            ->where('sms_code', $received)
            ->where('mobile', $phonenumber)
            ->where('verified',0)
            ->get()->first();
        if ($code && $code->sms_code == $received) {
            DB::table('users')
                ->where('sms_code', $received)
                ->where('mobile', $phonenumber)
                ->update(['verified' => 1]);
            return response()->json(['success' => true, 'message' => 'Verify']);
        } else {
            return response()->json(['success' => false, 'message' => 'NotVerify', 'mobile' => $phonenumber]);
        }
    }

    //
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11',
            'code' => 'required|digits:5',
            'password' => 'required|string|min:8'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if($request->has('mobile')){
            if(preg_match('/09([0-9]{9})/',$request->get('mobile'),$match)){
                $request->merge(['mobile'=>'9'.$match[1]]) ;

            }
        }
        $phonenumber = $request->input('mobile') ;
        $verified = User::where('mobile', $phonenumber)
            ->where('verified', 1)
            ->where('sms_code', $request->input('code'))
            ->first() ;


//        return substr($phonenumber, 1) ;
//        return $phonenumber ;
        if ($verified) {

            $data = [
                'name' => $request->input('name'),
                'mobile' => $phonenumber,
                'password' => Hash::make($request->input('password')),
                'verified'=>2,
                'status'=>1,
            ];

            $verified->update($data);
            $token = JWTAuth::fromUser($verified);
            /*DB::table('users')
                ->where('mobile', $phonenumber)
                ->where('verified', 1)
                ->where('sms_code', $request->input('code'))
                ->update(['verified'=>2]);
            */
            return response()->json(['success' => true, 'token' => compact('token'), 'data' => $verified, 'message' => 'Registered']);
        } else {
            return response()->json(['success' => false, 'message' => 'NoVerify']);

        }

    }

    public function update(Request $request)
    {
//        TODO MAKE CHANGE (UPDATE USER)
//        TODO MAKE CHANGE (UPDATE USER)

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        $input = $request->only([
            'name','family','email','birth_date','state','gender','ncode','address','postal_code','lat','lng','shakhe',
            'reshte1','reshte2','reshte3','city','password'
        ]);
        $user = auth('api')->user();
        if (!empty($request->input('password'))) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return response()->json(['success' => false, 'errors' => $errors]);
            }
            $input ['password'] = Hash::make($request->input('password'));
        }
        $id = $user->id;
        $userItem = User::find($id);
        if ($userItem->update($input)) {
            return response()->json(['success' => true, 'data' => $userItem]);
        } else {
            return response()->json(['success' => false, 'message' => 'ErrorUpdate']);
        }
    }

    public function getShakheh()
    {
        $data=Shakheh::all();
        return response()->json(['success'=>true,'data'=>$data]);
    }
    public function getReshteh($id)
    {
        $data=Reshteh::where('shakheh_id',$id)->get();
        return response()->json(['success'=>true,'data'=>$data]);
    }
    public function getGerayesh($id)
    {
        $data=Gerayesh::where('reshteh_id',$id)->get();
        return response()->json(['success'=>true,'data'=>$data]);
    }
    public function getDasteh($id)
    {
        $data=Dasteh::where('gerayesh_id',$id)->get();
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function getCities($id)
    {
        $data=City::where('state_id',$id)->get();
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function getStates()
    {
        $data=State::all();
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function me()
    {

        $states=State::where('status',1)->pluck('id','title');
        $data=[];
        $data['user']=auth('api')->user();
        $data['states']=$states;
        $data['shakhe']=[];
        $data['reshte']=[];

        return response()->json(['success'=>true,'data'=>$data]);
    }
    public function addTransaction(Request $request){

        $input=['price'=>$request->amount];
        $input['port']='mellat';
        $input['status']='INIT';
        $input['created_at']=Carbon::now();
        $input['user_id']=Auth::user()->id;
        $input['type']='usercharge';

        $rowid=DB::table('gateway_transactions')
            ->insertGetId($input);

            return response()->json([
                'success'=>true,'data'=>$rowid
            ]);
    }
}
