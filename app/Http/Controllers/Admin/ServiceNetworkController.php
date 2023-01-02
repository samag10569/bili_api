<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ServiceNetworkRequest;
use App\Models\ServiceNetwork;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ServiceNetworkController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = ServiceNetwork::query();

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


        return View('admin.service-network.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.service-network.add')->with('status', $status);
    }

    public function postAdd(ServiceNetworkRequest $request)
    {
        $input = $request->all();


        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/service-network/';
                $pathMain = 'assets/uploads/service-network/main/';
                $pathBig = 'assets/uploads/service-network/big/';
                $pathMedium = 'assets/uploads/service-network/medium/';
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
        ServiceNetwork::create($input);

        return Redirect::action('Admin\ServiceNetworkController@getIndex')
            ->with('success', 'بال خدماتی جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = ServiceNetwork::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];
        return View('admin.service-network.edit')
            ->with('data', $data)->with('status', $status);

    }


    public function postEdit($id, ServiceNetworkRequest $request)
    {

        $input = $request->except('_token');

        $news = ServiceNetwork::find($id);
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/service-network/';
            $pathMain = 'assets/uploads/banner/main/';
            $pathBig = 'assets/uploads/banner/big/';
            $pathMedium = 'assets/uploads/banner/medium/';
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


        return Redirect::action('Admin\BannerController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }



    public function postDelete(ServiceNetworkRequest $request)
    {
        $images = ServiceNetwork::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/service-network/' . $item);
        }
        if (Banner::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\ServiceNetworkController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
