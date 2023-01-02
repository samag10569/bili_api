<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterductionRequest extends FormRequest
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
                case 'add':
                    return [
                        'user_id' => 'required|exists:users,id',
                        'company_name' => 'required|min:2',
                        'letter_id' => 'required|min:2',


                    ];
                break;
                case 'edit':
                    return [
                        'user_id' => 'required|exists:users,id',
                        'company_name' => 'required|min:2',
                        'letter_id' => 'required|min:2',


                    ];
                break;
                case 'delete':
                    return [
                        'deleteId' => 'required',
                    ];
                break;
                case 'sort':
                    return [
                        'update' => 'required',
                    ];
                break;
                case 'user':
                    return [
                        'code' => 'required|integer',
                    ];
                break;
            }

        }
    }
}
