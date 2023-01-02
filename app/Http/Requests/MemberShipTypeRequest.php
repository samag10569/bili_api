<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberShipTypeRequest extends FormRequest
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
                        'title' => 'required|min:2',
                        'price' => 'required|numeric',
                        'time' => 'required|numeric'
                    ];
                    break;
            }
        } else {
            return [
                'membership_type_id' => 'required|exists:membership_type,id'
            ];
        }

    }
}
