<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if($this->segment(1) == config('site.admin')){
            switch($this->segment(3)){
                case 'add':
                    return [
                        'name'       => 'required|min:2',
                        'family'     => 'required|min:2',
                        'email'      => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                        'password'   => 'required|min:6',
                        'repassword' => 'required|same:password',
                        'group'      => 'array'
                    ];
                    break;
                case 'edit':
                    return [
                        'name'     => 'required|min:2',
                        'family'   => 'required|min:2',
                        'password'   => 'min:6',
                        'repassword' => 'same:password',
                        'group'    => 'array'
                    ];
                    break;
                case 'ban':
                    return [
                        'type'    => 'required',
                        'id'    => 'required',
                    ];
                    break;
                case 'delete':
                    return [
                        'deleteId'    => 'required',
                    ];
                    break;
                case 'group-add':
                    return [
                        'name'   => 'required|min:2',
                        'access' => 'required',
                    ];
                    break;
                case 'group-edit':
                    return [
                        'name'   => 'required|min:2',
                        'access' => 'required',
                    ];
                    break;
                case 'group-delete':
                    return [
                        'deleteId'    => 'required',
                    ];
                    break;
                case 'change-password':
                    return [
                        'password'   => 'required|min:6',
                        'repassword' => 'required|same:password',
                    ];
                    break;
            }

        }
    }
}
