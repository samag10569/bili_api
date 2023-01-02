<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapacityRequest extends FormRequest
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
                        'date' => 'required',
                        'capacity' => 'required',

                    ];
                    break;
                case 'edit':
                    return [
                        'date' => 'required',
                        'capacity' => 'required',

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
