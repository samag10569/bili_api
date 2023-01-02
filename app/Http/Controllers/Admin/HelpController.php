<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HelpRequest;
use App\Models\Help;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class HelpController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Help::query();
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

        if (!$request->has('sort')) {
            $query->orderBy('help.id', 'DESC');
        }
        $query->deleteTemp();
        $data = $query->paginate(15);


        return View('admin.help.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        $status_user = [
            '1' => 'بله',
            '0' => 'خیر',
        ];
        return View('admin.help.add')->with('status', $status)->with('status_user', $status_user)->with('place', 0);
    }

    public function postAdd(HelpRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/help/';
                $pathMain = 'assets/uploads/help/main/';
                $pathBig = 'assets/uploads/help/big/';
                $pathMedium = 'assets/uploads/help/medium/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                if (!File::isDirectory($pathMain)) {
                    File::makeDirectory($pathMain);
                }
                if (!File::isDirectory($pathBig)) {
                    File::makeDirectory($pathBig);
                }
                if (!File::isDirectory($pathMedium)) {
                    File::makeDirectory($pathMedium);
                }
                $fileName = md5(microtime()) . ".$extension";
                $request->file('image')->move($pathMain, $fileName);
                $kaboom = explode(".", $fileName);
                $fileExt = end($kaboom);
                Resizer::resizePic($pathMain . $fileName, $pathMedium . $fileName, 400, 400, $fileExt);
                Resizer::resizePic($pathMain . $fileName, $pathBig . $fileName, 800, 800, $fileExt, True);
                $input['image'] = $fileName;
            }
        }

        Help::create($input);

        return Redirect::action('Admin\HelpController@getIndex')
            ->with('success', 'اخبار جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Help::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        $status_user = [
            '1' => 'بله',
            '0' => 'خیر',
        ];
        $place = $data->place;
        return View('admin.help.edit')
            ->with('data', $data)->with('status', $status)->with('status_user', $status_user)
            ->with('place', $place);

    }


    public function postEdit($id, HelpRequest $request)
    {
        $input = $request->except('_token');

        $news = Help::find($id);
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/help/';
            $pathMain = 'assets/uploads/help/main/';
            $pathBig = 'assets/uploads/help/big/';
            $pathMedium = 'assets/uploads/help/medium/';
            File::delete($pathBig . $news->image);
            File::delete($pathMedium . $news->image);
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                if (!File::isDirectory($pathMain)) {
                    File::makeDirectory($pathMain);
                }
                if (!File::isDirectory($pathBig)) {
                    File::makeDirectory($pathBig);
                }
                if (!File::isDirectory($pathMedium)) {
                    File::makeDirectory($pathMedium);
                }
                $fileName = md5(microtime()) . ".$extension";
                $request->file('image')->move($pathMain, $fileName);
                $kaboom = explode(".", $fileName);
                $fileExt = end($kaboom);
                Resizer::resizePic($pathMain . $fileName, $pathMedium . $fileName, 400, 400, $fileExt);
                Resizer::resizePic($pathMain . $fileName, $pathBig . $fileName, 800, 800, $fileExt, True);
                $input['image'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        $news->where('id', $id)->update($input);


        return Redirect::action('Admin\HelpController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(HelpRequest $request)
    {
//        $images = Help::whereIn('id', $request->get('deleteId'))->get();
//        foreach ($images as $item) {
//            $item->delete_temp = time();
//            $item->save();
//           // File::delete('assets/uploads/help/big/' . $item);
//            //File::delete('assets/uploads/help/medium/' . $item);
//        }

        Help::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);

        return Redirect::action('Admin\HelpController@getIndex')
            ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');

    }
}
