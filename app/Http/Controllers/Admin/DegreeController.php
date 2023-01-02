<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DegreeRequest;
use App\Models\Degree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class DegreeController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Degree::query();
        $query->whereStatus(1);

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

        $data = $query->paginate(15);

        return View('admin.degree.index')
            ->with('data', $data);
    }


    public function postAdd(DegreeRequest $request)
    {
        $input = $request->all();

        $input['status'] = 1;

        Degree::create($input);

        return Redirect::action('Admin\DegreeController@getIndex')
            ->with('success', 'ظرفیت ثبت نام جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Degree::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.degree.edit')
            ->with('data', $data)->with('status', $status);
    }


    public function postEdit($id, DegreeRequest $request)
    {

        $input = $request->except('_token');

        $news = Degree::find($id);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\DegreeController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(DegreeRequest $request)
    {
        if (Degree::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\DegreeController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
