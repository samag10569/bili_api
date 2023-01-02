<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UnderMenuRequest;
use App\Models\Tab;
use App\Models\UnderMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class UnderMenuController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = UnderMenu::query();
        $query->whereStatus(1)->with('tab');

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

        $all = UnderMenu::where('status', 1)->orderBy('listorder', 'ASC')->get();
        $tabs = Tab::pluck('title', 'id')->toArray();
        return View('admin.under-menu.index')
            ->with('data', $data)->with('all', $all)->with('tabs', $tabs);
    }


    public function postAdd(UnderMenuRequest $request)
    {
        $input = $request->all();

        $input['status'] = 1;

        UnderMenu::create($input);

        return Redirect::action('Admin\UnderMenuController@getIndex')
            ->with('success', 'تب هدر جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = UnderMenu::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $tabs = Tab::pluck('title', 'id')->toArray();

        return View('admin.under-menu.edit')
            ->with('data', $data)->with('status', $status)->with('tabs', $tabs);
    }


    public function postEdit($id, UnderMenuRequest $request)
    {

        $input = $request->except('_token');

        $news = UnderMenu::find($id);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\UnderMenuController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(UnderMenuRequest $request)
    {
        if (UnderMenu::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\UnderMenuController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function postSort(UnderMenuRequest $request)
    {
        if ($request->get('update') == "update") {
            $count = 1;
            if ($request->get('update') == 'update') {
                foreach ($request->get('arrayorder') as $idval) {
                    $sortList = UnderMenu::find($idval);
                    $sortList->listorder = $count;
                    $sortList->save();
                    $count++;
                }
                echo 'با موفقیت ذخیره شد.';
            }

        }

    }

}
