<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FooterUnderMenuRequest;
use App\Models\FooterTab;
use App\Models\FooterUnderMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class FooterUnderMenuController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = FooterUnderMenu::query();
        $query->whereStatus(1)->with('footerTab');

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

        $all = FooterUnderMenu::where('status', 1)->orderBy('listorder', 'ASC')->get();
        $tabs = FooterTab::pluck('title', 'id')->toArray();
        return View('admin.footer-under-menu.index')
            ->with('data', $data)->with('all', $all)->with('tabs', $tabs);
    }


    public function postAdd(FooterUnderMenuRequest $request)
    {
        $input = $request->all();

        $input['status'] = 1;

        FooterUnderMenu::create($input);

        return Redirect::action('Admin\FooterUnderMenuController@getIndex')
            ->with('success', 'تب فوتر جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = FooterUnderMenu::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $tabs = FooterTab::pluck('title', 'id')->toArray();

        return View('admin.footer-under-menu.edit')
            ->with('data', $data)->with('status', $status)->with('tabs', $tabs);
    }


    public function postEdit($id, FooterUnderMenuRequest $request)
    {

        $input = $request->except('_token');

        $news = FooterUnderMenu::find($id);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\FooterUnderMenuController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(FooterUnderMenuRequest $request)
    {
        if (FooterUnderMenu::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\FooterUnderMenuController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function postSort(FooterUnderMenuRequest $request)
    {
        if ($request->get('update') == "update") {
            $count = 1;
            if ($request->get('update') == 'update') {
                foreach ($request->get('arrayorder') as $idval) {
                    $sortList = FooterUnderMenu::find($idval);
                    $sortList->listorder = $count;
                    $sortList->save();
                    $count++;
                }
                echo 'با موفقیت ذخیره شد.';
            }

        }

    }

}
