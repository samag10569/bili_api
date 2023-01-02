<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectedRequest extends FormRequest
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
                case 'edit':
                    return [
                        'name' => 'sometimes|required|min:2',
                        'family' => 'sometimes|required|min:2',
//                        'father_name' => 'sometimes|required|min:2',
//                        'birth' => 'sometimes|required',
//                        'mobile' => 'sometimes|required|iran_mobile',
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
