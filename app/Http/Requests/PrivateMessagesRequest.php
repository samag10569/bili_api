<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrivateMessagesRequest extends FormRequest
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
                case 'send':
                    return [
                        'user_id_to' => 'required|exists:users,id',
                        'subject' => 'required|min:2',
                        'message' => 'required|min:2',
                    ];
                    break;
                case 'replay':
                    return [
                        'subject' => 'required|min:2',
                        'message' => 'required|min:2',
                    ];
                    break;
                case 'user':
                    return [
                        'code' => 'required',
                    ];
                    break;
                case 'edit':
                    return [
                        'subject' => 'required|min:2',
                        'message' => 'required|min:2',
                    ];
                    break;
                case 'delete':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;
            }

        }
    }
}
