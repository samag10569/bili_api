<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\User;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class NewsController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = News::query();
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
            $query->orderBy('news.id', 'DESC');
        }
        $query->deleteTemp();
        $data = $query->paginate(15);


        return View('admin.news.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.news.add')->with('status', $status);
    }

    public function postAdd(NewsRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/news/';
                $pathMain = 'assets/uploads/news/main/';
                $pathBig = 'assets/uploads/news/big/';
                $pathMedium = 'assets/uploads/news/medium/';
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

        News::create($input);

        return Redirect::action('Admin\NewsController@getIndex')
            ->with('success', 'اخبار جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = News::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.news.edit')
            ->with('data', $data)->with('status', $status);

    }


    public function postEdit($id, NewsRequest $request)
    {
        $input = $request->except('_token');

        $news = News::find($id);
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/news/';
            $pathMain = 'assets/uploads/news/main/';
            $pathBig = 'assets/uploads/news/big/';
            $pathMedium = 'assets/uploads/news/medium/';
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


        return Redirect::action('Admin\NewsController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(NewsRequest $request)
    {
        /* $images = News::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
         foreach ($images as $item) {
             File::delete('assets/uploads/news/big/' . $item);
             File::delete('assets/uploads/news/medium/' . $item);
         }
         if (News::destroy($request->get('deleteId'))) {
             return Redirect::action('Admin\NewsController@getIndex')
                 ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
         } */


        News::whereIn('id', $request->get('deleteId'))->update(['delete_temp' => time()]);

        return Redirect::action('Admin\NewsController@getIndex')
            ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');


    }
}
