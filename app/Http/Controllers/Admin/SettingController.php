<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;

use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Setting::query();
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

        $data = $query->paginate(15);


        return View('admin.news.index')
            ->with('data', $data);
    }

    public function getEdit($id)
    {
        $data = Setting::find($id);
        return View('admin.setting.edit')
            ->with('data', $data);

    }


    public function postEdit($id, SettingRequest $request)
    {
        $input = $request->except('_token');

        $news = Setting::find($id);
        if ($request->hasFile('logo_water_mark')) {
            $path = 'assets/uploads/setting/';
            File::delete($path . $news->logo_water_mark);
            $extension = $request->file('logo_water_mark')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                 $fileName = md5(microtime()) . ".$extension";
                $request->file('logo_water_mark')->move($path, $fileName);
                $input['logo_water_mark'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('favicon')) {
            $path = 'assets/uploads/setting/';
            File::delete($path . $news->favicon);
            $extension = $request->file('favicon')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                 $fileName = md5(microtime()) . ".$extension";
                $request->file('favicon')->move($path, $fileName);
                $input['favicon'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('logo_header')) {
            $path = 'assets/uploads/setting/';
            File::delete($path . $news->logo_header);
            $extension = $request->file('logo_header')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                 $fileName = md5(microtime()) . ".$extension";
                $request->file('logo_header')->move($path, $fileName);
                $input['logo_header'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        if ($request->hasFile('logo_footer')) {
            $path = 'assets/uploads/setting/';
            File::delete($path . $news->logo_footer);
            $extension = $request->file('logo_footer')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                 $fileName = md5(microtime()) . ".$extension";
                $request->file('logo_footer')->move($path, $fileName);
                $input['logo_footer'] = $fileName;
            } else {
                return Redirect::back()->with('error', 'عکس ارسالی صحیح نیست.');
            }
        }
        $news->where('id', $id)->update($input);


        return Redirect::action('Admin\SettingController@getEdit',array(1))->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(NewsRequest $request)
    {
        $images = News::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/news/big/' . $item);
            File::delete('assets/uploads/news/medium/' . $item);
        }
        if (News::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\NewsController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
