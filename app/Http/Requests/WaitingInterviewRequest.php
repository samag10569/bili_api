<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WaitingInterviewRequest extends FormRequest
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
                case 'add':
                    return [
                        'name' => 'required|min:2',
                        'family' => 'required|min:2',
//                        'father_name' => 'required|min:2',
//                        'birth' => 'required',
                        'mobile' => 'required|iran_mobile|unique:users,mobile,NULL,id,deleted_at,NULL',
//                        'national_id' => 'melli_code',
//                        'branch_id' => 'required',
//                        'category_id' => 'required',
//                        'state_id' => 'required',
//                        'branch' => 'required',
//                        'city' => 'address',
//                        'postal_code' => 'numeric|min:10',
                        'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                    ];
                    break;
                case 'edit':
                    return [
                        'name' => 'sometimes|required|min:2',
                        'family' => 'sometimes|required|min:2',
//                        'father_name' => 'sometimes|required|min:2',
//                        'birth' => 'sometimes|required',
//                        'national_id' => 'sometimes|required|melli_code',
//                        'date_interview' => 'sometimes|required',
//                        'time_interview' => 'sometimes|required',
//                        'branch_id' => 'sometimes|required',
//                        'category_id' => 'sometimes|required',
//                        'state_id' => 'sometimes|required',
//                        'branch' => 'sometimes|required',
//                        'city' => 'sometimes|required|address',
//                        'postal_code' => 'sometimes|required|numeric|min:10',
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
