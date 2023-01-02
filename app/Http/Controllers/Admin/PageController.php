<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PagesRequest;
use App\Models\Pages;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Pages::query();

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
            $query->orderBy('pages.id', 'DESC');
        }

        $data = $query->paginate(15);


        return View('admin.page.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.page.add')->with('status', $status);
    }

    public function postAdd(PagesRequest $request)
    {
        $input = $request->all();


        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/page/';
                $pathMain = 'assets/uploads/page/main/';
                $pathBig = 'assets/uploads/page/big/';
                $pathMedium = 'assets/uploads/page/medium/';
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
        // $input['status'] = 1;
        Pages::create($input);

        return Redirect::action('Admin\PageController@getIndex')
            ->with('success', 'صفحه ایستا جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = Pages::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.page.edit')
            ->with('data', $data)->with('status', $status);

    }


    public function postEdit($id, PagesRequest $request)
    {

        $rules = [
            'link' => 'required|unique:pages,link,' . $id,
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $input = $request->except('_token');

            $news = Pages::find($id);
            if ($request->hasFile('image')) {
                $path = 'assets/uploads/page/';
                $pathMain = 'assets/uploads/page/main/';
                $pathBig = 'assets/uploads/page/big/';
                $pathMedium = 'assets/uploads/page/medium/';
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
            return Redirect::action('Admin\PageController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }

    }


    public function postDelete(PagesRequest $request)
    {
        $images = Pages::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/page/' . $item);
        }
        if (Pages::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\PageController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
