<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ScientificCommentsRequest;
use App\Models\Scientific;
use App\Models\ScientificComments;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ScientificCommentsController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = ScientificComments::query();
        $query->with('user', 'publishedby');

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
                $query->where('category_id', $request->get('category_id'));
            }

        }

        $query->orderBy('id', 'DESC');

        $data = $query->paginate(15);

        return View('admin.scientific-comments.index')
            ->with('data', $data);
    }

    public function getAdd()
    {
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        return View('admin.scientific-comments.add')->with('status', $status)
            ->with('category', $category);
    }

    public function postAdd(ScientificCommentsRequest $request)
    {
        $input = $request->all();


        $input['user_id'] = Auth::User()->id;
        $user=User::find(Auth::User()->id);
        $input['isadmin']=$user->admin;

        Scientific::create($input);

        return Redirect::action('Admin\ScientificController@getIndex')
            ->with('success', 'مطلب جدید با موفقیت ثبت شد.');
    }


    public function getEdit($id)
    {
        $data = ScientificComments::find($id);
        $status = [
            '1' => 'فعال',
            '0' => 'غیر فعال',
        ];

        return View('admin.scientific-comments.edit')
            ->with('data', $data)->with('status', $status);

    }


    public function postEdit($id, ScientificCommentsRequest $request)
    {
        $input = $request->except('_token');

        $scientific = ScientificComments::find($id);

        $scientific['published_by']=Auth::user()->id;

        $scientific->where('id', $id)->update($input);


        return Redirect::action('Admin\ScientificCommentsController@getIndex')->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

    public function postDelete(ScientificCommentsRequest $request)
    {
        $images = ScientificComments::whereIn('id', $request->get('deleteId'))->get();
        foreach ($images as $item) {
            $item->delete();
        }
        
            return Redirect::action('Admin\ScientificCommentsController@getIndex')
                ->with('success', 'کدهای مورد نظر با موفقیت حذف شدند.');
        
    }
}
