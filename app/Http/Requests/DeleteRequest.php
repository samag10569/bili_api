<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
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

                case 'cancel-user':
                    return [
                        'delete_temp' => 'required',
                    ];
                    break;
                case 'user':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;

                case 'cancel-help':
                    return [
                        'delete_temp' => 'required',
                    ];
                    break;
                case 'help':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;

                case 'cancel-scientific-category':
                    return [
                        'delete_temp' => 'required',
                    ];
                    break;
                case 'scientific-category':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;

                case 'cancel-scientific':
                    return [
                        'delete_temp' => 'required',
                    ];
                    break;
                case 'scientific':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;

                case 'cancel-news':
                    return [
                        'delete_temp' => 'required',
                    ];
                    break;
                case 'news':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;
            }

        }
    }
}
