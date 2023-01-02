<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class BranchController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Branch::query();
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

        $all = Branch::where('status', 1)->orderBy('listorder', 'ASC')->get();
        return View('admin.branch.index')
            ->with('data', $data)->with('all', $all);
    }


    public function postAdd(BranchRequest $request)
    {
        $input = $request->all();
        $input['status'] = 1;
        Branch::create($input);

        

        return Redirect::action('Admin\BranchController@getIndex')
            ->with('success', 'مقطع  جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Branch::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.branch.edit')
            ->with('data', $data)->with('status', $status);
    }


    public function postEdit($id, BranchRequest $request)
    {

        $input = $request->except('_token');

        $news = Branch::find($id);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\BranchController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(BranchRequest $request)
    {
        if (Branch::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\BranchController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function postSort(BranchRequest $request)
    {
        if ($request->get('update') == "update") {
            $count = 1;
            if ($request->get('update') == 'update') {
                foreach ($request->get('arrayorder') as $idval) {
                    $sortList = Branch::find($idval);
                    $sortList->listorder = $count;
                    $sortList->save();
                    $count++;
                }
                echo 'با موفقیت ذخیره شد.';
            }

        }

    }

}
