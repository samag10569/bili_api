<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TabRequest;
use App\Models\Tab;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class TabController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Tab::query();
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

        $all = Tab::where('status', 1)->orderBy('listorder', 'ASC')->get();
        return View('admin.tab.index')
            ->with('data', $data)->with('all', $all);
    }


    public function postAdd(TabRequest $request)
    {
        $input = $request->all();

        $input['status'] = 1;

        Tab::create($input);

        return Redirect::action('Admin\TabController@getIndex')
            ->with('success', 'تب هدر جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Tab::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.tab.edit')
            ->with('data', $data)->with('status', $status);
    }


    public function postEdit($id, TabRequest $request)
    {

        $input = $request->except('_token');

        $news = Tab::find($id);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\TabController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(TabRequest $request)
    {
        if (Tab::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\TabController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function postSort(TabRequest $request)
    {
        if ($request->get('update') == "update") {
            $count = 1;
            if ($request->get('update') == 'update') {
                foreach ($request->get('arrayorder') as $idval) {
                    $sortList = Tab::find($idval);
                    $sortList->listorder = $count;
                    $sortList->save();
                    $count++;
                }
                echo 'با موفقیت ذخیره شد.';
            }

        }

    }

}
