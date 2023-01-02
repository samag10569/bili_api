<?php

namespace App\Http\Controllers\Site;

use App\Events\LogUserEvent;
use App\Http\Requests\UnSubscribeRequest;
use App\Models\Banner;
use App\Models\ContactsList;
use App\Models\EmailExcel;
use App\Models\IgnoreEmail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mews\Captcha\Facades\Captcha;

class HomeController extends Controller
{
    public function getIndex()
    {
        return null;
        $banner = Banner::whereStatus(1)
            ->where(function ($query) {
                $query->whereNull('section')
                    ->orWhere('section', '');
            })
            ->orderBy('id', 'ASC')
            ->get();

        return view('site.index')->with('banner', $banner);
    }

    public function refereshCapcha()
    {
        return Captcha::img();
    }

    public function postLogout()
    {
        event(new LogUserEvent(Auth::user()->id, 'logout', Auth::user()->id));
        Session::forget('returnId');
        Auth::logout();
        return Redirect::action('Site\HomeController@getIndex');
    }

    public function getUnSubscribe($email, $type, $type_id)
    {
        if ($type == 'email') {
            $data = User::whereEmail($email)->whereId($type_id)->first();
        } elseif ($type == 'introduction') {
            $data = ContactsList::whereEmail($email)->whereId($type_id)->first();
        } elseif ($type == 'excel') {
            $data = EmailExcel::whereEmail($email)->whereId($type_id)->first();
        }

        if (!$data) abort(404);

        return view('site.unsubscribe')
            ->with('email', $email)
            ->with('type', $type)
            ->with('type_id', $type_id);

    }

    public function postUnSubscribe(UnSubscribeRequest $request)
    {
        $input = $request->all();
        if ($input['type'] == 'email') {
            $data = User::whereEmail($input['email'])->whereId($input['type_id'])->first();
        } elseif ($input['type'] == 'introduction') {
            $data = ContactsList::whereEmail($input['email'])->whereId($input['type_id'])->first();
        } elseif ($input['type'] == 'excel') {
            $data = EmailExcel::whereEmail($input['email'])->whereId($input['type_id'])->first();
        }

        if (!$data) abort(404);

        IgnoreEmail::create($input);
        return Redirect::action('Site\HomeController@getIndex')->with('success', 'با موفقیت انجام شد.');
    }
}
