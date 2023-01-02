<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdsTextRequest;
use App\Http\Requests\BannerRequest;
use App\Models\AdsText;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Dasteh;
use App\Models\Gerayesh;
use App\Models\Reshteh;
use App\Models\Shakheh;
use App\Models\State;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class AdsTextController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = AdsText::query();

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
            $query->orderBy('ads_texts.id', 'DESC');
        }

        $data = $query->paginate(15);

        return View('admin.adstext.index')
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

        return view('admin.adstext.add')->with('status', $status)->with('gender', $gender)
            ->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('dasteh', $dasteh)
            ->with('cities', $cities)
            ->with('state_id', $state_id);
    }

    public function postAdd(AdsTextRequest $request)
    {
        $input = $request->all();

       // $input['status'] = 1;
        AdsText::create($input);

        return Redirect::action('Admin\AdsTextController@getIndex')
            ->with('success', 'تبلیغ متنی جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = AdsText::find($id);
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
        return View('admin.adstext.edit')
            ->with('data', $data)->with('status', $status)->with('gender', $gender)
            ->with('shakhe', $shakhe)
            ->with('gerayesh', $gerayesh)
            ->with('reshteh', $reshteh)
            ->with('dasteh', $dasteh)
            ->with('cities', $cities)
            ->with('state_id', $state_id);

    }


    public function postEdit($id, AdsTextRequest $request)
    {

        $input = $request->except('_token');

        $news = AdsText::find($id);
        $news->where('id', $id)->update($input);


        return Redirect::action('Admin\AdsTextController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }



    public function postDelete(BannerRequest $request)
    {

        if (AdsText::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\AdsTextController@getIndex')
                ->with('success', 'تبلیغات متنی مورد نظر با موفقیت حذف شدند.');
        }
    }
}
