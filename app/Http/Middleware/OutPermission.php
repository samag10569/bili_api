<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Route;

class OutPermission
{

    public function __construct(Guard $auth)
    {

        $this->auth = $auth;

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $segments = $request->segments();
        $segmentCounter = count($segments);

        if ($segmentCounter > 1) {
            $actionName = 'index';
        }

        if ($segmentCounter > 2) {
            $actionName = camel_case($segments[2]);
        }

        // karbar hatman baiad Login bashad
        if ($this->auth->check()) {
            if ($this->auth->user()->out) {
                // ghesmate aval URL baiad ba esme out dar Config barabar bashe
                if ($segments[0] == Config::get('site.out')) {
                    // agar tedad ghesmat hae url bishtar az 0 bod va safhe aval out nabood
                    if (($segmentCounter > 1) && Route::currentRouteAction() !== 'App\Http\Controllers\Out\HomeController@getIndex') {
                        foreach ($this->auth->user()->roles as $role) {


                            // permission ha be sorat array
                            $permission = unserialize($role->permission);

                            if (is_array($permission)) {
                                if ($permission['fullAccess'] == 1) {
                                    return $next($request);
                                }
                                // agar url bishtar az 1 ghesmat bood va ghesmate tarif shode toe permision ha bood
                                if (($segmentCounter > 1) && array_key_exists($segments[1], $permission)) {


                                    // agar url faght 2 ghesmat bood maslan /out/users khode method ro be index taghir mide
                                    if ($segmentCounter == 2) {
                                        $segments[2] = 'index';
                                        //return $next($request);
                                    }

                                    // agar bishtar az 2 ghesmat bood

                                    if ((count($segments) > 2) && array_key_exists($actionName, $permission[$segments[1]])) {
                                        return $next($request);
                                    }
                                }
                            }
                        }
                        // agar segment bozorgtar az 0 bood va safhe aval out bood
                    } elseif (($segmentCounter > 0) && Route::currentRouteAction() == 'App\Http\Controllers\Out\HomeController@getIndex') {
                        return $next($request);
                    }
                }
            }
        }
        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        } else {
            if (Auth::check() and Auth::user()->out) {
                return redirect('/out')->with('error', 'شما به این بخش دسترسی ندارید.');
            } else {
                return redirect()->action('Auth\LoginController@getOutLogin');
            }
        }
    }


}
