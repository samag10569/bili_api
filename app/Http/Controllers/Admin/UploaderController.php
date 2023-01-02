<?php

namespace App\Http\Controllers\Admin;

use App\Events\LogUserEvent;
use App\Http\Requests\UploaderRequest;
use App\Models\Uploader;
use Classes\Resizer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class UploaderController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = Uploader::query();

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
            $query->orderBy('uploader.id', 'DESC');
        }

        $data = $query->paginate(15);


        return View('admin.uploader.index')
            ->with('data', $data);
    }


    public function postAdd(UploaderRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $ext = ['jpg', 'jpeg', 'png', 'pdf', 'rar', 'zip'];
            if (in_array($extension, $ext)) {
                $path = 'assets/uploads/uploader/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                $fileName = md5(microtime()) . ".$extension";
                $request->file('image')->move($path, $fileName);
                $input['image'] = $fileName;
            }
        }

        $input['status'] = 1;
        $upload = Uploader::create($input);

        event(new LogUserEvent($upload->id, 'add', Auth::user()->id));

        return Redirect::action('Admin\UploaderController@getIndex')
            ->with('success', 'آپلودر جدید با موفقیت ثبت شد.');
    }


    public function postDelete(UploaderRequest $request)
    {
        $images = Uploader::whereIn('id', $request->get('deleteId'))->pluck('image')->all();
        foreach ($images as $item) {
            File::delete('assets/uploads/uploader/' . $item);
        }
        if (Uploader::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\UploaderController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        }
    }
}
