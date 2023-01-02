<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DegreeRequest extends FormRequest
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
                        'title' => 'required',
                        'max' => 'required',
                        'min' => 'required',

                    ];
                    break;
                case 'edit':
                    return [
                        'title' => 'required',
                        'max' => 'required',
                        'min' => 'required',

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
