<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoreScientificRequest extends FormRequest
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
                        'name' => 'required|min:2',
                        'family' => 'required|min:2',
                        'station' => 'required|min:2',
//                        'mobile' => 'required|iran_mobile',
                        'branch_id' => 'required',
                        'category_id' => 'required',
//                        'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                    ];
                    break;
                case 'edit':
                    return [
                        'name' => 'required|min:2',
                        'family' => 'required|min:2',
                        'station' => 'required|min:2',
                        'mobile' => 'required|iran_mobile',
                        'branch_id' => 'required',
                        'category_id' => 'required',
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
