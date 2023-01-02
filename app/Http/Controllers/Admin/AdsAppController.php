<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdsAppRequest;
use App\Models\AdsApp;
use App\Models\Category;
use App\Models\City;
use App\Models\Dasteh;
use App\Models\Gerayesh;
use App\Models\Reshteh;
use App\Models\Shakheh;
use App\Models\State;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class AdsAppController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = AdsApp::query();

        if ($request->has('search')) {

            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }


            if ($request->has('title')) {
                $query->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

        }

        if (!$request->has('sort')) {
            $query->orderBy('ads_apps.id', 'DESC');
        }

        $data = $query->paginate(15);

        return View('admin.adsapp.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'تکمیل شده',
            '0' => 'در انتظار بررسی',
            '-1' => 'رد شده'
        ];
        $gender = [
            '1' => 'مرد ',
            '2' => 'زن',
        ];
        $shakhe = Shakheh::whereNotNull('id')->pluck('title', 'id')->all();
        $shakhe = ['' => 'انتخاب کنید . . .'] + $shakhe;
        $gerayesh = Gerayesh::whereNotNull('id')->pluck('title', 'id')->all();
        $gerayesh = ['' => 'انتخاب کنید . . .'] + $gerayesh;
        $reshteh = Reshteh::whereNotNull('id')->pluck('title', 'id')->all();
        $reshteh = ['' => 'انتخاب کنید . . .'] + $reshteh;
        $dasteh = Dasteh::whereNotNull('id')->pluck('title', 'id')->all();
        $dasteh = ['' => 'انتخاب کنید . . .'] + $dasteh;
        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'انتخاب کنید . . .'] + $state_id;
        $cities = City::pluck('title', 'id')->all();
        $cities = ['' => 'انتخاب کنید . . .'] + $cities;
        return View('admin.adsapp.add')
            ->with('status', $status)->with('gender', $gender)
            ->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('dasteh', $dasteh)
            ->with('cities', $cities)
            ->with('state_id', $state_id);
    }

    public function postAdd(AdsAppRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/ads_app/');
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('logo')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('logo'), 'assets/uploads/ads_app/');
            if ($fileName) {
                $input['logo'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time().$video->getClientOriginalName();
            $extension = $video->getClientOriginalExtension();
           /* $tempPath = $video->getRealPath();
            $fileSize = $video->getSize();
            $mimeType = $video->getMimeType();*/
            // Valid File Extensions
            $valid_extension = array("avi","webm","mp4","m4p","m4v","wmv","swf");
            if(in_array(strtolower($extension),$valid_extension)){
                $location = 'assets/uploads/ads_app/';
                $video->move($location,$filename);
                $input['video'] = $filename;
            } else {
                return Redirect::back()->with('error', 'ویدئو ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('app')) {
            $app = $request->file('app');
            $filename = time().$app->getClientOriginalName();
            $extension = $app->getClientOriginalExtension();
            /* $tempPath = $video->getRealPath();
             $fileSize = $video->getSize();
             $mimeType = $video->getMimeType();*/
            // Valid File Extensions
            $valid_extension = array("ipa","apk","jpg");
            if(in_array(strtolower($extension),$valid_extension)){
                $location = 'assets/uploads/ads_app/';
                $app->move($location,$filename);
                $input['app'] = $filename;
            } else {
                return Redirect::back()->with('error', 'فایل ارسالی صحیح نیست.');
            }
        }
        AdsApp::create($input);

        return Redirect::action('Admin\AdsAppController@getIndex')
            ->with('success', 'تبلیغ ویدئویی جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = AdsApp::find($id);
        $status = [
            '1' => 'تکمیل شده',
            '0' => 'در انتظار بررسی',
            '-1' => 'رد شده'
        ];
        $gender = [
            '1' => 'مرد ',
            '2' => 'زن',
        ];
        $shakhe = Shakheh::whereNotNull('id')->pluck('title', 'id')->all();
        $shakhe = ['' => 'انتخاب کنید . . .'] + $shakhe;
        $gerayesh = Gerayesh::whereNotNull('id')->pluck('title', 'id')->all();
        $gerayesh = ['' => 'انتخاب کنید . . .'] + $gerayesh;
        $reshteh = Reshteh::whereNotNull('id')->pluck('title', 'id')->all();
        $reshteh = ['' => 'انتخاب کنید . . .'] + $reshteh;
        $dasteh = Dasteh::whereNotNull('id')->pluck('title', 'id')->all();
        $dasteh = ['' => 'انتخاب کنید . . .'] + $dasteh;
        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'انتخاب کنید . . .'] + $state_id;
        $cities = City::pluck('title', 'id')->all();
        $cities = ['' => 'انتخاب کنید . . .'] + $cities;
        return View('admin.adsapp.edit')
            ->with('data', $data)->with('status', $status)->with('gender', $gender)->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('cities', $cities)
            ->with('dasteh', $dasteh)->with('state_id', $state_id);

    }


    public function postEdit($id, AdsAppRequest $request)
    {

        $input = $request->except('_token');

        $adsapp = AdsApp::find($id);
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/ads_app/');
            $pathBig = 'assets/uploads/ads_app/big/';
            $pathMedium = 'assets/uploads/ads_app/medium/';
            File::delete($pathBig . $adsapp->image);
            File::delete($pathMedium . $adsapp->image);
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('logo')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('logo'), 'assets/uploads/ads_app/');
            $pathBig = 'assets/uploads/ads_app/big/';
            $pathMedium = 'assets/uploads/ads_app/medium/';
            File::delete($pathBig . $adsapp->logo);
            File::delete($pathMedium . $adsapp->logo);
            if ($fileName) {
                $input['logo'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس لوگو ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('video')) {
            $pathapp = 'assets/uploads/ads_app/';
            File::delete($pathapp . $adsapp->video);
            $video = $request->file('video');
            $filename = time().$video->getClientOriginalName();
            $extension = $video->getClientOriginalExtension();
            /* $tempPath = $video->getRealPath();
             $fileSize = $video->getSize();
             $mimeType = $video->getMimeType();*/
            // Valid File Extensions
            $valid_extension = array("avi","webm","mp4","m4p","m4v","wmv","swf");
            if(in_array(strtolower($extension),$valid_extension)){
                $location = 'assets/uploads/ads_app/';
                $video->move($location,$filename);
                $input['video'] = $filename;
            } else {
                return Redirect::back()->with('error', 'ویدئو ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('app')) {
            $pathapp = 'assets/uploads/ads_app/';
            File::delete($pathapp . $adsapp->app);
            $app = $request->file('app');
            $filename = time().$app->getClientOriginalName();
            $extension = $app->getClientOriginalExtension();
            /* $tempPath = $video->getRealPath();
             $fileSize = $video->getSize();
             $mimeType = $video->getMimeType();*/
            // Valid File Extensions
            $valid_extension = array("ipa","apk","jpg");
            if(in_array(strtolower($extension),$valid_extension)){
                $location = 'assets/uploads/ads_app/';
                $app->move($location,$filename);
                $input['app'] = $filename;
            } else {
                return Redirect::back()->with('error', 'فایل ارسالی صحیح نیست.');
            }
        }
        $adsapp->where('id', $id)->update($input);


        return Redirect::action('Admin\AdsAppController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }



    public function postDelete(AdsAppRequest $request)
    {

        if (AdsApp::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\AdsAppController@getIndex')
                ->with('success', 'تبلیغات نرم افزاری مورد نظر با موفقیت حذف شدند.');
        }
    }
}
