<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class CrmPermission
{

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        $segments = $request->segments();
        if ($this->auth->check()) {
            if ($this->auth->user()->member) {
                if ($segments[0] == Config::get('site.crm')) {

                    if ($this->auth->user()->mobile == null) {

                        $msg = 'دوست گرامی تا زمانی که اطلاعات تماس خود را تکمیل نکنید اکانت شما قفل می باشد</br>';
                        $msg .= 'لطفا جهت تکمیل اطلاعات کاربری خود روی ویرایش پروفایل کلیک کنید';
                        Session::put('error', $msg);

                        if (count($segments) > 1) {
                            if ($segments[1] == 'profile') {
                                return $next($request);
                            }
                        } else {
                            return $next($request);
                        }

                    } else {
                        Session::forget('error');
                        return $next($request);
                    }

                }
            }
        }
        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        } else {
            if (Auth::check() and Auth::user()->member) {
                return redirect('/' . config('site.crm'))->with('error', 'شما به این بخش دسترسی ندارید.');
            } else {
                return redirect()->action('Auth\LoginController@getCrmLogin');
            }
        }
    }
}
