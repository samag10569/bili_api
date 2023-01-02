<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Degree;
use App\Models\MembershipType;
use App\Models\UserInfo;
use App\User;
use Classes\Helper;
use Classes\UserCheck;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Events\LogUserEvent;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'logout']);
    }

    public function getLogin()
    {
        if (Auth::check() and Auth::user()->admin)
            return Redirect::action('Admin\HomeController@getIndex') ;
        else
            return view('admin.auth.login') ;
    }

    public function postLogin(AuthRequest $request)
    {
        $login = Auth::attempt([
            'admin' => 1,
            'status' => 1,
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);

        if ($login) {
            event(new LogUserEvent(Auth::user()->id, 'login', Auth::user()->id));
            return Redirect::action('Admin\HomeController@getIndex');
        }
        return Redirect::action('Auth\LoginController@getLogin')
            ->with('error', 'اطلاعات ورود اشتباه می باشد.');

    }

    public function getOutLogin()
    {
        if (Auth::check() and Auth::user()->out)
            return Redirect::action('Out\HomeController@getIndex');
        else
            return view('out.auth.login');
    }

    public function postOutLogin(AuthRequest $request)
    {
        $login = Auth::attempt([
            'out' => 1,
            'status' => 1,
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);

        if ($login) {
            event(new LogUserEvent(Auth::user()->id, 'login', Auth::user()->id));
            return Redirect::action('Out\HomeController@getIndex');
        }
        return Redirect::action('Auth\LoginController@getOutLogin')
            ->with('error', 'اطلاعات ورود اشتباه می باشد.');

    }

    public function getCrmLogin()
    {
        if (Auth::check() and Auth::user()->member) {
//            if (Auth::user()->step != null and Auth::user()->step != '')
//                return Redirect::action('Site\RegisterController@get' . Auth::user()->step);
//            else
            return Redirect::action('Crm\HomeController@getIndex');
        } else
            return view('crm.auth.login');
    }

    public function postCrmLogin(AuthRequest $request)
    {
        $login = Auth::attempt([
            'member' => 1,
            'status' => 1,
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);

        if ($login) {
            Session::forget('returnId');
            //TODO: remove comment
            UserCheck::upMemberShipType(Auth::id());
            return Redirect::action('Crm\HomeController@getIndex');
        }
        return Redirect::action('Auth\LoginController@getCrmLogin')
            ->with('error', 'اطلاعات ورود اشتباه می باشد.');

    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->scopes(['https://www.google.com/m8/feeds/'])->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
            $user_details = User::whereEmail($user->email)->first();
            $checker = new UserCheck();
            if ($user_details) {
                if (!$user_details->import_contacts) {
                    $checker->importContacts($user->token, $user_details->id);
                }
                Auth::loginUsingId($user_details->id);
//                if ($user_details->step != null and $user_details->step != '')
//                    return Redirect::action('Site\RegisterController@get' . $user_details->step);
//                else
                return Redirect::action('Crm\HomeController@getIndex');
            } else {
                $name = explode('@', $user->email);

                $input['name'] = $name[0];
                $input['family'] = '';
                $input['email'] = $user->email;
                $input['email_confirm'] = 1;
                $input['date_interview'] = time();
                $input['password'] = bcrypt($user->email);
                $input['rejection'] = 0;
                $input['member'] = 1;
                $input['register_id'] = '-1';
                $input['status_id'] = 1;
                $input['step'] = 'Step2';
                $userCreate = User::create($input);

                $inputCreate['user_id'] = $userCreate->id;
                $inputCreate['postal_code'] = 1111111111;
                $inputCreate['father_name'] = '-';
                $inputCreate['interview_type_id'] = 0;

                User::where('id', $inputCreate['user_id'])
                    ->update(['user_code' => $checker->user_code($inputCreate['user_id'])]);
                $inputCreate['score'] = 0;
                $inputCreate['score_id'] = Degree::where('min', '<=', $inputCreate['score'])
                    ->where('max', '>', $inputCreate['score'])
                    ->firstorfail()->title;
                UserInfo::create($inputCreate);

                $checker->importContacts($user->token, $userCreate->id);

                Auth::loginUsingId($inputCreate['user_id']);

                if ($userCreate->step != null and $userCreate->step != '')
                    return Redirect::action('Site\RegisterController@get' . $userCreate->step);
                else
                    return Redirect::action('Crm\HomeController@getIndex');
            }
        } catch (Exception $e) {
            return Redirect::action('Auth\LoginController@redirectToProvider');
        }
    }


    public function redirectToProviderTest()
    {

    }

    public function handleProviderCallbackTest()
    {

    }
}
