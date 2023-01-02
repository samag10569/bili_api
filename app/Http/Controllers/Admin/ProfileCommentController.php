<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileCommentRequest;
use App\Models\ProfileComment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ProfileCommentController extends Controller
{
    public function getIndex(Request $request)
    {

        $query = ProfileComment::with('sender','user');

        if ($request->has('search')) {
            if ($request->has('start') and $request->has('end')) {
                $start = explode('/', $request->get('start'));
                $end = explode('/', $request->get('end'));

                $s = jmktime(0, 0, 0, $start[1], $start[0], $start[2]);
                $e = jmktime(0, 0, 0, $end[1], $end[0], $end[2]);

                $query->whereBetween('created_at', array($s, $e));
            }
        }

        $data = $query->paginate(15);


        return View('admin.profile-comment.index')
            ->with('data', $data);
    }


    public function getEdit($id)
    {
        $data = ProfileComment::find($id);

        return View('admin.profile-comment.edit')
            ->with('data', $data);
    }


    public function postEdit($id, ProfileCommentRequest $request)
    {

        $input = $request->except('_token');

        $news = ProfileComment::find($id);

        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\ProfileCommentController@getIndex')
            ->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }
    public function postDelete(ProfileCommentRequest $request)
    {
        if (ProfileComment::destroy($request->get('deleteId'))) {
            return Redirect::action('Admin\ProfileCommentController@getIndex')
                ->with('success', 'نظرات انتخاب شده با موفقیت حذف شدند.');
        }
    }
}
