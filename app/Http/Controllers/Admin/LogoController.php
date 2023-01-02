<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LogoRequest;
use App\Models\Logo;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class LogoController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Logo::query();

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
            $query->orderBy('logo.id', 'DESC');
        }

        $data = $query->paginate(15);


        return View('admin.logo.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.logo.add')->with('status', $status);
    }

    public function postAdd(LogoRequest $request)
    {
        $input = $request->all();


        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/logo/';
                $pathMain = 'assets/uploads/logo/main/';
                $pathBig = 'assets/uploads/logo/big/';
                $pathMedium = 'assets/uploads/logo/medium/';
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
        //$input['status'] = 1;
        Logo::create($input);

        return Redirect::action('Admin\LogoController@getIndex')
            ->with('success', 'بنر جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Logo::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.logo.edit')
            ->with('data', $data)->with('status', $status);

    }


    public function postEdit($id, LogoRequest $request)
    {

        $input = $request->except('_token');


        $news = Logo::find($id);
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/logo/';
            $pathMain = 'assets/uploads/logo/main/';
            $pathBig = 'assets/uploads/logo/big/';
            $pathMedium = 'assets/uploads/logo/medium/';
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


        return Redirect::action('Admin\LogoController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');
 
    }



    public function postDelete(LogoRequest $request)
    {
        $images = Logo::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/logo/' . $item);
        }
        if (Logo::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\LogoController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
