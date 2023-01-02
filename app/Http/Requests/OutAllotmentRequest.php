<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutAllotmentRequest extends FormRequest
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
        if ($this->segment(1) == config('site.out')) {
            switch ($this->segment(3)) {
                case 'edit':
                    return [
                        'allotment_status' => 'required',
                        'inspector_status' => 'required',
                    ];
                    break;
            }
        }
    }
}
