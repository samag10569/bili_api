<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CredibilityRequest;
use App\Models\Credibility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CredibilityController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Credibility::query();
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

        $all = Credibility::where('status', 1)->orderBy('listorder', 'ASC')->get();
        return View('admin.credibility.index')
            ->with('data', $data)->with('all', $all);
    }


    public function postAdd(CredibilityRequest $request)
    {
        $input = $request->all();

        $input['status'] = 1;

        Credibility::create($input);

        return Redirect::action('Admin\CredibilityController@getIndex')
            ->with('success', 'آیتم جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Credibility::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.credibility.edit')
            ->with('data', $data)->with('status', $status);
    }


    public function postEdit($id, CredibilityRequest $request)
    {

        $input = $request->except('_token');

        $news = Credibility::find($id);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\CredibilityController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(CredibilityRequest $request)
    {
        if (Credibility::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\CredibilityController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function postSort(CredibilityRequest $request)
    {
        if ($request->get('update') == "update") {
            $count = 1;
            if ($request->get('update') == 'update') {
                foreach ($request->get('arrayorder') as $idval) {
                    $sortList = Credibility::find($idval);
                    $sortList->listorder = $count;
                    $sortList->save();
                    $count++;
                }
                echo 'با موفقیت ذخیره شد.';
            }

        }

    }

}
