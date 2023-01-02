<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CapacityRequest;
use App\Models\Capacity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CapacityController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Capacity::query();

        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('date', array($s, $e));
            }
            if ($request->has('capacity')) {
                $query->where('capacity', '<', $request->get('capacity'));
            }
        }

        $data = $query->orderBy('date','DESC')->paginate(15);

        return View('admin.capacity.index')
            ->with('data', $data);
    }


    public function postAdd(CapacityRequest $request)
    {
        $input = $request->all();

        $input['status'] = 1;
        $date = explode('/', $request->get('date'));
        $time = jmktime(0, 0, 0, $date[1], $date[0], $date[2]);
        $input['date'] = $time;
        Capacity::create($input);

        return Redirect::action('Admin\CapacityController@getIndex')
            ->with('success', 'ظرفیت ثبت نام جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Capacity::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.capacity.edit')
            ->with('data', $data)->with('status', $status);
    }


    public function postEdit($id, CapacityRequest $request)
    {

        $input = $request->except('_token');

        $news = Capacity::find($id);
        $date = explode('/', $request->get('date'));
        $input['date'] = jmktime(0, 0, 0, $date[1], $date[0], $date[2]);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\CapacityController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(CapacityRequest $request)
    {
        if (Capacity::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\CapacityController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
