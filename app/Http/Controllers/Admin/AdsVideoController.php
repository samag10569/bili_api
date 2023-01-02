<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdsVideoRequest;
use App\Models\AdsVideo;
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

class AdsVideoController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = AdsVideo::query();

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
            $query->orderBy('ads_videos.id', 'DESC');
        }

        $data = $query->paginate(15);

        return View('admin.adsvideo.index')
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
        return view('admin.adsvideo.add')->with('status', $status)->with('gender', $gender)->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('cities', $cities)
            ->with('dasteh', $dasteh)->with('state_id', $state_id);
    }

    public function postAdd(AdsVideoRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/ads_video/');
            if ($fileName) {
                $input['image'] = $fileName;
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
                $location = 'assets/uploads/ads_video/';
                $video->move($location,$filename);
                $input['video'] = $filename;
            } else {
                return Redirect::back()->with('error', 'ویدئو ارسالی صحیح نیست.');
            }
        }
        AdsVideo::create($input);

        return Redirect::action('Admin\AdsVideoController@getIndex')
            ->with('success', 'تبلیغ ویدئویی جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = AdsVideo::find($id);
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
        return View('admin.adsvideo.edit')
            ->with('data', $data)->with('status', $status)->with('gender', $gender)->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('cities', $cities)
            ->with('dasteh', $dasteh)->with('state_id', $state_id);

    }


    public function postEdit($id, AdsVideoRequest $request)
    {

        $input = $request->except('_token');

        $adsvideo = AdsVideo::find($id);
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/ads_video/');
            $pathBig = 'assets/uploads/ads_video/big/';
            $pathMedium = 'assets/uploads/ads_video/medium/';
            File::delete($pathBig . $adsvideo->image);
            File::delete($pathMedium . $adsvideo->image);
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('video')) {
            $pathvideo = 'assets/uploads/ads_video/';
            File::delete($pathvideo . $adsvideo->video);
            $video = $request->file('video');
            $filename = time().$video->getClientOriginalName();
            $extension = $video->getClientOriginalExtension();
            /* $tempPath = $video->getRealPath();
             $fileSize = $video->getSize();
             $mimeType = $video->getMimeType();*/
            // Valid File Extensions
            $valid_extension = array("avi","webm","mp4","m4p","m4v","wmv","swf");
            if(in_array(strtolower($extension),$valid_extension)){
                $location = 'assets/uploads/ads_video/';
                $video->move($location,$filename);
                $input['video'] = $filename;
            } else {
                return Redirect::back()->with('error', 'ویدئو ارسالی صحیح نیست.');
            }
        }
        $adsvideo->where('id', $id)->update($input);


        return Redirect::action('Admin\AdsVideoController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }



    public function postDelete(AdsVideoRequest $request)
    {

        if (AdsVideo::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\AdsVideoController@getIndex')
                ->with('success', 'تبلیغات ویئویی مورد نظر با موفقیت حذف شدند.');
        }
    }
}
