<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdsOrderRequest;
use App\Models\AdsAppHit;
use App\Models\AdsBillboardHit;
use App\Models\AdsImageHit;
use App\Models\AdsOrder;
use App\Models\AdsOrderCategory;
use App\Models\AdsText;
use App\Models\AdsTextHit;
use App\Models\AdsVideoHit;
use App\Models\Category;
use App\Models\City;
use App\Models\Dasteh;
use App\Models\Gerayesh;
use App\Models\Reshteh;
use App\Models\Shakheh;
use App\Models\State;
use App\User;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class AllAdsController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = DB::select(DB::raw('
          SELECT id,title,user_id,created_at,"ads_apps" as type,price FROM ads_apps
          UNION 
          SELECT id,title,user_id,created_at,"ads_billboards" as type,price FROM ads_billboards
          UNION
          SELECT id,title,user_id,created_at,"ads_images" as type,price FROM ads_images
          UNION
          SELECT id,title,user_id,created_at,"ads_texts" as type,price FROM ads_texts
          UNION
          SELECT id,title,user_id,created_at,"ads_videos" as type,price FROM ads_videos
          
          
          order by created_at
          
          
          
          '));

        foreach ($query as $key=>$row){
            $query[$key]->user=User::find($row->user_id);
        }



        //if (!$request->has('sort')) {
        //    $query->orderBy('ads_order.id', 'DESC');
        //}

        //$data = $query->paginate(15);

        return View('admin.allads.index')
            ->with('data', $query);
    }

    public function getIndex2($type,$id,Request $request)
    {
        switch ($type){
            case 'ads_texts':
            $query=AdsTextHit::where('ads_id',$id);
            break;
            case 'ads_images':
                $query=AdsImageHit::where('ads_id',$id);
                break;
            case 'ads_videos':
                $query=AdsVideoHit::where('ads_id',$id);
                break;
            case 'ads_apps':
                $query=AdsAppHit::where('ads_id',$id);
                break;
            case 'ads_billboards':
                $query=AdsBillboardHit::where('ads_id',$id);
                break;
        }

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
            $query->orderBy('id', 'DESC');
        }

        $data = $query->paginate(15);

        return View('admin.allads.index2')
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
        $cats=AdsOrderCategory::pluck('title', 'id')->all();
        return view('admin.allads.add')->with('status', $status)->with('gender', $gender)
            ->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('cats', $cats)
            ->with('dasteh', $dasteh)->with('state_id', $state_id);
    }

    public function postAdd(AdsOrderRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/ads_image/');
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        AdsOrder::create($input);

        return Redirect::action('Admin\AdsOrderController@getIndex')
            ->with('success', 'تبلیغ تصویری جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = AdsOrder::find($id);
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
        $cats=AdsOrderCategory::pluck('title', 'id')->all();
        return View('admin.allads.edit')
            ->with('data', $data)->with('status', $status)->with('gender', $gender)
            ->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('cats', $cats)
            ->with('dasteh', $dasteh)->with('state_id', $state_id);

    }


    public function postEdit($id, AdsOrderRequest $request)
    {

        $input = $request->except('_token');

        $allads = AdsOrder::find($id);
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/ads_image/');
            $pathBig = 'assets/uploads/ads_image/big/';
            $pathMedium = 'assets/uploads/ads_image/medium/';
            File::delete($pathBig . $allads->image);
            File::delete($pathMedium . $allads->image);
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        $allads->where('id', $id)->update($input);


        return Redirect::action('Admin\AdsOrderController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }



    public function postDelete(AdsOrderRequest $request)
    {

        if (AdsOrder::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\AdsOrderController@getIndex')
                ->with('success', 'تبلیغات تصویری مورد نظر با موفقیت حذف شدند.');
        }
    }
}
