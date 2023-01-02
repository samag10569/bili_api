<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordResets;
use App\Models\Setting;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getResetPassword($token = null)
    {
        if ($token == null) {
            return view('crm.auth.email');
        } else {
            if (PasswordResets::whereToken($token)->exists()) {
                $userEmail = PasswordResets::whereToken($token)->first()->email;
                $user = User::whereEmail($userEmail)->first();
                if (!$user) abort(404);
                return view('crm.auth.reset')
                    ->with('token', $token)
                    ->with('user', $user);
            } else {
                abort(404);
            }
        }
    }

    public function postSendEmail(ResetPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        if (!$user) abort(404);
        if (PasswordResets::whereEmail($request->get('email'))->exists())
            PasswordResets::whereEmail($request->get('email'))->delete();
        $token = substr(md5(rand()), 0, 32);
        $input = [
            'email' => $request->get('email'),
            'token' => $token
        ];
        PasswordResets::create($input);
        $sender = Setting::first()->sender;
        try {
            Mail::send('crm.auth.email-content', ['user' => $user, 'token' => $token], function ($m) use ($user, $sender) {
                $m->from($sender, 'Register ejavan Form')
                    ->to($user->email, $user->name . ' ' . $user->family)
                    ->subject('فراموشی رمز عبور');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return Redirect::action('Auth\LoginController@getCrmLogin')
            ->with('success', 'ایمیل با موفقیت ارسال شد.');
    }

    public function postResetPassword(ResetPasswordRequest $request)
    {
        if (PasswordResets::whereToken($request->get('token'))->exists()) {
            $userEmail = PasswordResets::whereToken($request->get('token'))->first()->email;
            $user = User::whereEmail($userEmail)->first();
            if (!$user) abort(404);
            $user->update(['password' => bcrypt($request->get('password'))]);
            return Redirect::action('Auth\LoginController@getCrmLogin')
                ->with('success', 'رمز شما با موفقیت ویرایش شد.');
        } else {
            abort(404);
        }
    }
}
