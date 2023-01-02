<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        switch ($this->segment(2)) {
            case 'step1':
                return [
                    'name' => 'required|min:2',
                    'family' => 'required|min:2',
                    'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                    'mobile' => 'required|iran_mobile|unique:users,mobile,NULL,id,deleted_at,NULL',
                   //'date_interview' => 'sometimes|required',
//                    'image' => 'mimes:jpeg,jpg,png',
                    'password' => 'required|min:6',
                    'rePassword' => 'required|same:password',
                ];
                break;
            case 'step2':
                return [
                    'state_id' => 'required',
                    'city' => 'required|min:10',
                    'postal_code' => 'required|numeric|min:10',
                    'employment_status' => 'min:2',
                    'company' => 'min:2',
                    'industry' => 'min:2',
                ];
                break;
            case 'step3':
                return [
                    'father_name' => 'required|min:2',
                    'birth' => 'required',
                    'national_id' => 'required|melli_code',
                    'branch_id' => 'required',
                    'category_id' => 'required',
                    'branch' => 'required',
                ];
                break;
            case 'confirm':
                return [
                    'type' => 'required',
                    'confirm_code' => 'required',
                ];
                break;
        }

    }

}
