<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

class MsgController extends Controller
{
    public function getInternal(Request $request){
        $user=auth()->user();
        $data=DB::table('notifications')
            ->where('user_id',$user->id)
            ->where('status',1)
            ->get();
        return response()->json(['success'=>true,'data'=>$data]);
    }

    public function postTicket(Request $request)
    {
        $input = $request->except('_token');
        $input['file'] = 0;
        $input['user_id'] = Auth::id();
        $input['factualy_id'] = 1;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'content' => 'required|min:10',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $ext = ['doc', 'docx', 'pdf']; // other
            $path = 'assets/uploads/support/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['file'] = $fileName;
            } else {
                return Redirect::back()->withInput()->with('error', 'فایل ارسالی صحیح نیست.');
            }
        }

        Message::create($input);
        return response()->json(['success'=>true,'message'=>'با موفقیت ثبت شد.']);
    }
}
