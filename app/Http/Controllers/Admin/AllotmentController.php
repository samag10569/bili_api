<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\AllotmentRequest;
use App\Models\Allotment;
use App\Models\AllotmentCategory;
use App\User;
use Classes\Resizer;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class AllotmentController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Allotment::with('category');
        $setCat = false;
        $all = [];

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
            if ($request->has('category_id')) {
                $query->where('category_id', '=', $request->get('category_id'));
                $setCat = true;
                $all = Allotment::where('status', 1)->where('category_id', '=', $request->get('category_id'))->orderBy('listorder', 'ASC')->get();
            }

        }

        if (!$request->has('sort')) {
            $query->orderBy('allotment.id', 'DESC');
        }

        $data = $query->paginate(15);

        $category_id = AllotmentCategory::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $category_id = ['' => 'انتخاب کنید . . .'] + $category_id;

        return View('admin.allotment.index')
            ->with('data', $data)
            ->with('category_id', $category_id)
            ->with('setcat', $setCat)
            ->with('all', $all);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $option = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $category_id = AllotmentCategory::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();

        return View('admin.allotment.add')->with('status', $status)
            ->with('category_id', $category_id)
            ->with('option', $option);
    }

    public function postAdd(AllotmentRequest $request)
    {
        $input = $request->all();
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/allotment/');
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }

        if (!$request->has('score')) $input['score'] = 0;
        if (!$request->has('capacity')) $input['capacity'] = 0;
        if (!$request->has('profit')) $input['profit'] = 0;
        if (!$request->has('gold_price')) $input['gold_price'] = 0;
        if (!$request->has('price')) $input['price'] = 0;

        $allotment = Allotment::create($input);
        event(new LogUserEvent($allotment->id, 'add', Auth::user()->id));

        return Redirect::action('Admin\AllotmentController@getIndex')
            ->with('success', 'خدمت جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Allotment::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        $option = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        $category_id = AllotmentCategory::Orderby('listorder', 'ASC')->pluck('title', 'id')->all();

        return View('admin.allotment.edit')
            ->with('data', $data)->with('status', $status)
            ->with('category_id', $category_id)
            ->with('option', $option);

    }


    public function postEdit($id, AllotmentRequest $request)
    {
        $input = $request->except('_token');

        $allotment = Allotment::find($id);
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/allotment/');
            $pathBig = 'assets/uploads/allotment/big/';
            $pathMedium = 'assets/uploads/allotment/medium/';
            File::delete($pathBig . $allotment->image);
            File::delete($pathMedium . $allotment->image);
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }


        if (!$request->has('score')) $input['score'] = 0;
        if (!$request->has('capacity')) $input['capacity'] = 0;
        if (!$request->has('profit')) $input['profit'] = 0;
        if (!$request->has('gold_price')) $input['gold_price'] = 0;
        if (!$request->has('price')) $input['price'] = 0;


        $allotment->where('id', $id)->update($input);
        event(new LogUserEvent($allotment->id, 'edit', Auth::user()->id));


        return Redirect::action('Admin\AllotmentController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(AllotmentRequest $request)
    {
        if (Allotment::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\AllotmentController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }

    public function postSort(AllotmentRequest $request)
    {
        if ($request->get('update') == 'update') {
            $count = 1;
            foreach ($request->get('arrayorder') as $idval) {
                $sortList = Allotment::find($idval);
                $sortList->listorder = $count;
                $sortList->save();
                $count++;
            }
            return response()->json('با موفقیت ذخیره شد.');
        }
    }
}
