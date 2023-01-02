<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdsApp;
use App\Models\AdsBillboard;
use App\Models\AdsImage;
use App\Models\AdsText;
use App\Models\AdsVideo;
use App\Models\State;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdsController extends Controller
{
    public function getTextView($id){
        $data=AdsText::with('state','city','shakhe','reshte','gerayesh','daste')->find($id);

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getImageView($id){
        $data=AdsImage::with('state','city','shakhe','reshte','gerayesh','daste')->find($id);

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getVideoView($id){
        $data=AdsVideo::with('state','city','shakhe','reshte','gerayesh','daste')->find($id);

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getAppView($id){
        $data=AdsApp::with('state','city','shakhe','reshte','gerayesh','daste')->find($id);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getTextOwn(){
        $data=AdsText::with('state','city','shakhe','reshte','gerayesh','daste')->where('user_id',Auth::user()->id)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getImageOwn(){
        $data=AdsImage::with('state','city','shakhe','reshte','gerayesh','daste')->where('user_id',Auth::user()->id)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getVideoOwn(){
        $data=AdsVideo::with('state','city','shakhe','reshte','gerayesh','daste')->where('user_id',Auth::user()->id)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getAppOwn(){
        $data=AdsApp::with('state','city','shakhe','reshte','gerayesh','daste')->where('user_id',Auth::user()->id)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getBillboardOwn(){
        $data=AdsBillboard::with('state','city','shakhe','reshte','gerayesh','daste')->where('user_id',Auth::user()->id)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getText(){
        $data=AdsText::with('state','city','shakhe','reshte','gerayesh','daste')->where('status',1)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getImage(){
        $data=AdsImage::with('state','city','shakhe','reshte','gerayesh','daste')->where('status',1)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getVideo(){
        $data=AdsVideo::with('state','city','shakhe','reshte','gerayesh','daste')->where('status',1)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getApp(){
        $data=AdsVideo::with('state','city','shakhe','reshte','gerayesh','daste')->where('status',1)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function addText(Request $request){
        $input = $request->except('_token');
        $input['user_id'] = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'content' => 'required|min:10',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        

        AdsText::create($input);
        return response()->json(['success'=>true,'message'=>'با موفقیت ثبت شد.']);

    }

    public function addImage(Request $request){
        $input = $request->except('_token');
        $input['user_id'] = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'content' => 'required|min:10',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png']; // other
            $path = 'assets/uploads/ads_images/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['image'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

//        todo unset token
        unset($input['token']);
        AdsImage::create($input);
        return response()->json(['success'=>true,'message'=>'با موفقیت ثبت شد.']);

    }

    public function addVideo(Request $request){
        $input = $request->except('_token');
        $input['user_id'] = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'content' => 'required|min:10',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png']; // other
            $path = 'assets/uploads/ads_images/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['image'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $extension = $file->getClientOriginalExtension();
            $ext = ['mp4', 'webp', 'mov']; // other
            $path = 'assets/uploads/ads_videos/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['video'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

//        todo unset token
        unset($input['token']);
        AdsVideo::create($input);
        return response()->json(['success'=>true,'message'=>'با موفقیت ثبت شد.']);

    }

    public function addBillboard(Request $request){
        
        $input = $request->except('_token');
        $input['user_id'] = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'content' => 'required|min:10',
            'billboard_id' => 'required',//TODO: validate
            'time'=>'required',
            'start_at'=>'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png']; // other
            $path = 'assets/uploads/ads_billboards/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['image'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $extension = $file->getClientOriginalExtension();
            $ext = ['mp4', 'webp', 'mov']; // other
            $path = 'assets/uploads/ads_billboards/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['video'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

//        TODO UNSET TOKEN
        unset($input['token']) ;
        AdsBillboard::create($input);
        return response()->json(['success'=>true,'message'=>'با موفقیت ثبت شد.']);

    }

    public function addApp(Request $request){
        $input = $request->except('_token');
        $input['user_id'] = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3',
            'content' => 'required|min:10',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png']; // other
            $path = 'assets/uploads/ads_billboards/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['image'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $extension = $file->getClientOriginalExtension();
            $ext = ['mp4', 'webp', 'mov']; // other
            $path = 'assets/uploads/ads_billboards/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['video'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png']; // other
            $path = 'assets/uploads/ads_billboards/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['logo'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

        if ($request->hasFile('app')) {
            $file = $request->file('app');
            $extension = $file->getClientOriginalExtension();
            $ext = ['mp4', 'webp', 'mov']; // other
            $path = 'assets/uploads/ads_billboards/';
            if (in_array($extension, $ext)) {
                $fileName = str_random(12) . md5(microtime()) . ".$extension";
                $file->move($path, $fileName);
                $input['app'] = $fileName;
            } else {
                return response()->json(['success'=>false,'message'=>'فایل ارسالی صحیح نیست.']);
            }
        }

//        TODO UNSET TOKEN
        unset($input['token']) ;
        AdsApp::create($input);
        return response()->json(['success'=>true,'message'=>'با موفقیت ثبت شد.']);

    }

}
