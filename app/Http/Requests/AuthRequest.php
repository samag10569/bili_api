<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->segment(1) == config('site.admin') || $this->segment(1) == config('site.out') || $this->segment(1) == config('site.crm')) {
            switch ($this->segment(2)) {
                case'login':
                    return [
                        'email' => 'required|email',
                        'password' => 'required|min:6',
                        'captcha' => 'required|captcha',
                    ];
                    break;
                case'reminder':
                    return [
                        'email' => 'required|email',
                    ];
                    break;
                case
                'reset-password':
                    return [
                        'email' => 'required|email',
                        'token' => 'required',
                        'password' => 'required|min:6|confirmed'
                    ];
                    break;
            }
        }
    }

    public
    function messages()
    {
        return [
            'email.required' => 'ایمیل الزامی است.',
            'email.email' => 'ایمیل صحیح وارد کنید.',
            'password.required' => 'رمز ورود الزامی است.',
            'captcha.captcha' => 'کد امنیتی را صحیح وارد کنید.'
        ];
    }
}
