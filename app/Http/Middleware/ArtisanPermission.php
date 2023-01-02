<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Route;

class ArtisanPermission
{

    public function __construct(Guard $auth)
    {

        $this->auth = $auth;

    }

    public function handle($request, Closure $next)
    {
        if (Schema::hasTable('users')) {
            if ($this->auth->check()) {
                if ($this->auth->user()->admin and $this->auth->user()->email == 'qut.soleimani@gmail.com') {
                    return $next($request);
                }
            }
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                if (Auth::check() and Auth::user()->admin) {
                    return redirect('/admin')->with('error', 'شما به این بخش دسترسی ندارید.');
                } else {
                    return redirect()->action('Auth\LoginController@getLogin');
                }
            }
        }
    }


}
