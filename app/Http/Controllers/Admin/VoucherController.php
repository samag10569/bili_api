<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BannerRequest;
use App\Models\Voucher;
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

class VoucherController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = Voucher::query();

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
            if ($request->has('code')) {
                $query->where('code', 'LIKE', '%' . $request->get('code') . '%');
            }

        }

        if (!$request->has('sort')) {
            $query->orderBy('id', 'DESC');
        }

        $data = $query->paginate(15);

        return View('admin.voucher.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیرفعال',
        ];



        return view('admin.voucher.add')->with('status', $status);
    }

    public function postAdd(Request $request)
    {
        $input = $request->all();

       // $input['status'] = 1;
        $from_date = explode('/', $input['from_date']);
        $input['from_date'] = jmktime(0, 0, 0, $from_date[1], $from_date[0], $from_date[2]);

        $to_date = explode('/', $input['to_date']);
        $input['to_date'] = jmktime(23, 59, 59, $to_date[1], $to_date[0], $to_date[2]);
        Voucher::create($input);

        return Redirect::action('Admin\VoucherController@getIndex')
            ->with('success', 'تبلیغ متنی جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Voucher::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیرفعال',
        ];
        return View('admin.voucher.edit')
            ->with('data', $data)->with('status', $status);

    }


    public function postEdit($id, Request $request)
    {

        $input = $request->except('_token');

        $from_date = explode('/', $input['from_date']);
        $input['from_date'] = jmktime(0, 0, 0, $from_date[1], $from_date[0], $from_date[2]);

        $to_date = explode('/', $input['to_date']);
        $input['to_date'] = jmktime(23, 59, 59, $to_date[1], $to_date[0], $to_date[2]);

        $news = Voucher::find($id);
        $news->where('id', $id)->update($input);


        return Redirect::action('Admin\VoucherController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }



    public function postDelete(BannerRequest $request)
    {

        if (Voucher::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\VoucherController@getIndex')
                ->with('success', 'تبلیغات متنی مورد نظر با موفقیت حذف شدند.');
        }
    }
}
