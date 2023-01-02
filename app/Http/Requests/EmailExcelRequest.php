<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailExcelRequest extends FormRequest
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
                        'count' => 'required|numeric',
                        'sender' => 'required|email',
                        'subject' => 'required',
                    ];
                    break;
                case 'import':
                    return [
                        'file' => 'required',
                    ];
                    break;
                case 'edit':
                    return [
                        'count' => 'required|numeric',
                        'sender' => 'required|email',
                        'subject' => 'required',
                    ];
                    break;
                case 'delete':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;
                case 'delete-error':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;
            }

        }
    }
}
