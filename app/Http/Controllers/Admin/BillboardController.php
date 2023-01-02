<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BillboardRequest;
use App\Http\Requests\ScientificRequest;
use App\Models\Billboard;
use App\Models\Scientific;
use App\Models\ScientificCategory;
use App\Models\State;
use App\User;
use Classes\Resizer;
use Classes\UploadImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Classes\MakeTree;

class BillboardController extends Controller
{
    public function getIndex(Request $request)
    {

        
        $query = Billboard::query();
        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {

                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
            if ($request->has('title')) {
                $query->where('name', 'LIKE', '%' . $request->get('title') . '%');
            }

        }

        if (!$request->has('sort')) {
            $query->orderBy('billboards.id', 'DESC');
        }
        $data = $query->paginate(15);

        return View('admin.billboard.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $type = [
            '0' => 'غیر هوشمند',
            '1' => 'هوشمند',
        ];
        $type2 = [
            '0' => 'بیلبورد بنری ساده',
            '1' => 'تلوزیون شهری',
        ];
        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'انتخاب کنید . . .'] + $state_id;


        return View('admin.billboard.add')->with('status', $status)->with('type2', $type2)->with('type', $type)->with('state_id', $state_id);
    }

    public function postAdd(BillboardRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/billboard/');
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }


        Billboard::create($input);

        return Redirect::action('Admin\BillboardController@getIndex')
            ->with('success', 'مطلب جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Billboard::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $type = [
            '0' => 'غیر هوشمند',
            '1' => 'هوشمند',
        ];
        $type2 = [
            '0' => 'بیلبورد بنری ساده',
            '1' => 'تلوزیون شهری',
        ];
        $state_id = State::whereNull('parent_id')->Orderby('listorder', 'ASC')->pluck('title', 'id')->all();
        $state_id = ['' => 'انتخاب کنید . . .'] + $state_id;
        return View('admin.billboard.edit')
            ->with('data', $data)->with('status', $status)->with('state_id', $state_id)
            ->with('type', $type) ->with('type2', $type2);
    }


    public function postEdit($id, BillboardRequest $request)
    {
        $input = $request->except('_token');

        $billboard = Billboard::find($id);
        if ($request->hasFile('image')) {
            $uploader = new UploadImg();
            $fileName = $uploader->uploadPic($request->file('image'), 'assets/uploads/billboard/');
            $pathBig = 'assets/uploads/billboard/big/';
            $pathMedium = 'assets/uploads/billboard/medium/';
            File::delete($pathBig . $billboard->image);
            File::delete($pathMedium . $billboard->image);
            if ($fileName) {
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        $billboard->where('id', $id)->update($input);


        return Redirect::action('Admin\BillboardController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(BillboardRequest $request)
    {
        /*  $images = Scientific::whereIn('id', $request->get('deleteId'))->get();
          foreach ($images as $item) {
             // File::delete('assets/uploads/scientific/big/' . $item);
             // File::delete('assets/uploads/scientific/medium/' . $item);
              $item->delete_temp = time();
              $item->save();
          }
  */
        if (Billboard::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\BillboardController@getIndex')
                ->with('success', 'بیلبورد های مورد نظر با موفقیت حذف شدند.');
        }

    }
}
