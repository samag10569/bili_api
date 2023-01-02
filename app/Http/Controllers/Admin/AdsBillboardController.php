<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdsBillboardRequest;
use App\Models\AdsBillboard;
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

class AdsBillboardController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = AdsBillboard::query();

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
            $query->orderBy('ads_billboards.id', 'DESC');
        }

        $data = $query->paginate(15);

        return View('admin.adsbillboard.index')
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
        return view('admin.adsbillboard.add')->with('status', $status)->with('gender', $gender)->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('cities', $cities)
            ->with('dasteh', $dasteh)->with('state_id', $state_id);
    }

    public function postAdd(AdsBillboardRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/ads_billboard/');
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('billboard')) {
            $billboard = $request->file('billboard');
            $filename = time().$billboard->getClientOriginalName();
            $extension = $billboard->getClientOriginalExtension();
           /* $tempPath = $billboard->getRealPath();
            $fileSize = $billboard->getSize();
            $mimeType = $billboard->getMimeType();*/
            // Valid File Extensions
            $valid_extension = array("avi","webm","mp4","m4p","m4v","wmv","swf");
            if(in_array(strtolower($extension),$valid_extension)){
                $location = 'assets/uploads/ads_billboard/';
                $billboard->move($location,$filename);
                $input['billboard'] = $filename;
            } else {
                return Redirect::back()->with('error', 'ویدئو ارسالی صحیح نیست.');
            }
        }
        AdsBillboard::create($input);

        return Redirect::action('Admin\AdsBillboardController@getIndex')
            ->with('success', 'تبلیغ ویدئویی جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = AdsBillboard::find($id);
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
        return View('admin.adsbillboard.edit')
            ->with('data', $data)->with('status', $status)->with('gender', $gender)->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('cities', $cities)
            ->with('dasteh', $dasteh)->with('state_id', $state_id);

    }


    public function postEdit($id, AdsBillboardRequest $request)
    {

        $input = $request->except('_token');

        $adsbillboard = AdsBillboard::find($id);
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/ads_billboard/');
            $pathBig = 'assets/uploads/ads_billboard/big/';
            $pathMedium = 'assets/uploads/ads_billboard/medium/';
            File::delete($pathBig . $adsbillboard->image);
            File::delete($pathMedium . $adsbillboard->image);
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('billboard')) {
            $pathbillboard = 'assets/uploads/ads_billboard/';
            File::delete($pathbillboard . $adsbillboard->billboard);
            $billboard = $request->file('billboard');
            $filename = time().$billboard->getClientOriginalName();
            $extension = $billboard->getClientOriginalExtension();
            /* $tempPath = $billboard->getRealPath();
             $fileSize = $billboard->getSize();
             $mimeType = $billboard->getMimeType();*/
            // Valid File Extensions
            $valid_extension = array("avi","webm","mp4","m4p","m4v","wmv","swf");
            if(in_array(strtolower($extension),$valid_extension)){
                $location = 'assets/uploads/ads_billboard/';
                $billboard->move($location,$filename);
                $input['billboard'] = $filename;
            } else {
                return Redirect::back()->with('error', 'ویدئو ارسالی صحیح نیست.');
            }
        }
        $adsbillboard->where('id', $id)->update($input);


        return Redirect::action('Admin\AdsBillboardController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }



    public function postDelete(AdsBillboardRequest $request)
    {

        if (AdsBillboard::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\AdsBillboardController@getIndex')
                ->with('success', 'تبلیغات ویئویی مورد نظر با موفقیت حذف شدند.');
        }
    }
}
