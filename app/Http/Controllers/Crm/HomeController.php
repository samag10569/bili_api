<?php

namespace App\Http\Controllers\Crm;

use App\Models\News;
use App\Models\Scientific;
use App\Models\ScientificCategory;
use App\User;
use Classes\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function getIndex()
    {
        if (Auth::user()->mobile == null) {
            return Redirect::action('Crm\ProfileController@getEdit');
        }
        $news = News::whereStatus(1)->deleteTemp()->latest()->take(5)->get();
        $scientific_category = ScientificCategory::where('status', 1)->deleteTemp()->pluck('title', 'id')->toArray();
        return view('crm.index')
            ->with('news', $news)
            ->with('scientific_category', $scientific_category);
    }

    public function postScientificAdd(Request $request)
    {

        $input = $request->all();
        $input['status'] = 0;
        $input['isadmin'] = 0;
        $input['user_id'] = Auth::user()->id;
        Scientific::create($input);

        return Redirect::action('Crm\HomeController@getIndex')
            ->with('success', 'مطلب علمی جدید با موفقیت ثبت شد.');

    }

    public function getBackAdmin()
    {
        if (Session::has('returnId')) {
            Auth::loginUsingId(Session::get('returnId'));
            Session::forget('returnId');
            return Redirect::to(Session::get('returnUrl'));
        } else {
            abort(404);
        }
    }

    public function getSearch(Request $request)
    {
        $user = User::whereUserCode($request->get('search'))
            ->whereMember(1)
            ->first();
        if ($user) {
            $name = Helper::seo($user->name) . '-' . Helper::seo($user->family);
            return Redirect::action('Crm\HomeController@getProfile', [$user->id, $name]);
        } else {
            return Redirect::back()->with('error', 'کاربر مورد نظر یافت نشد.');
        }
    }

    public function getProfile($id, $name = null)
    {
        $user = User::with('category', 'branchInfo', 'profileComment')->whereMember(1)->find($id);
        if ($user)
            return view('crm.profile.index')
                ->with('user', $user);
        else
            abort(404);
    }

    public function getFriendsAjax($user_id = null)
    {
        if ($user_id == null)
            $user = Auth::user();
        else
            $user = User::find($user_id);

        $friends = $user->getFriends();
        $array_friend = [];

        $name = Helper::seo($user->name) . '-' . Helper::seo($user->family);
        if (is_file(public_path() . '/assets/uploads/user/medium/' . $user->image))
            $image = asset('assets/uploads/user/medium/' . $user->image);
        else
            $image = asset('assets/site/images/avatar.png');

        $data = [
            'connectTo' => null,
            'url' => $image,
            'name' => $user->name . ' ' . $user->family,
            'field' => @$user->category->title . ' - ' . @$user->branchInfo->title . ' ' . @$user->info->branch,
            'link' => URL::action('Crm\HomeController@getProfile', [$user->id, $name]),
        ];
        $array_friend[] = ['id' => $user->id, 'data' => $data];


        foreach ($friends as $friend) {
            $name = Helper::seo($friend->name) . '-' . Helper::seo($friend->family);
            if (is_file(public_path() . '/assets/uploads/user/medium/' . $friend->image))
                $image = asset('assets/uploads/user/medium/' . $friend->image);
            else
                $image = asset('assets/site/images/avatar.png');

            $data = [
                'connectTo' => $user->id,
                'url' => $image,
                'name' => $friend->name . ' ' . $friend->family,
                'field' => @$user->category->title . ' - ' . @$user->branchInfo->title . ' ' . @$user->info->branch,
                'link' => URL::action('Crm\HomeController@getProfile', [$friend->id, $name]),
            ];
            $array_friend[] = ['id' => $friend->id, 'data' => $data];
        }
        return json_encode($array_friend);
    }

    public function getChart()
    {
        return view('crm.chart');
    }


    public function getConfirmEmail($user_id, $confirm_code)
    {
        $user = User::whereMember(1)
            ->where('email_confirm', 0)
            ->where('email_confirm_code', $confirm_code)
            ->whereId($user_id)
            ->first();
        if (!$user) abort(404);
        $user->update(['email_confirm' => 1]);
        return Redirect::action('Site\HomeController@getIndex')->with('success', 'ایمیل شما با موفقیت تایید شد.');
    }


}
