<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmailRequest;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class EmailController extends Controller
{
   

    public function getEdit()
    {
        $data = Setting::First();
        return View('admin.setting-email.edit')
            ->with('data', $data);

    }


    public function postEdit($id, EmailRequest $request)
    {
        $input = $request->except('_token');
        $news = Setting::find($id);
        $news->where('id', $id)->update($input);

        return Redirect::action('Admin\EmailController@getEdit',array(1))->with('success', 'آیتم مورد نظر با موفقیت ویرایش شد.');

    }

}
