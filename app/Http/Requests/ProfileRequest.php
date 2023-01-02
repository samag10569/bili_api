<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        switch ($this->segment(3)) {
            case 'pro':
                return [
                    'branch_id' => 'required',
                    'category_id' => 'required',
                    'branch' => 'required',
                    'employment_status' => 'min:2',
                    'company' => 'min:2',
                    'industry' => 'min:2',
                ];
                break;
            case 'edit':
                return [
                    'name' => 'required|min:2',
                    'family' => 'required|min:2',
                    'image' => 'mimes:jpeg,jpg,png',
                    'father_name' => 'required|min:2',
                    'birth' => 'required',
                    'national_id' => 'required|melli_code',
                    'state_id' => 'required',
                    'city' => 'required|min:10',
                    'postal_code' => 'required|numeric|min:10',

                ];
                break;
            case 'pass':
                return [
                    'old_password' => 'required|min:6',
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|same:password',

                ];
                break;
        }

    }

}
