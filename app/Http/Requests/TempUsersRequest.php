<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TempUsersRequest extends FormRequest
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
        if ($this->segment(1) == config('site.admin')) {
            switch ($this->segment(3)) {
                case 'send-confirm-phone':
                    return [
                        'user' => 'required|exists:users,id'
                    ];
                break;
                case 'send-confirm-email':
                    return [
                        'user' => 'required|exists:users,id'
                    ];
                break;
            }

        }
    }
}
