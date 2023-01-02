<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportRequest extends FormRequest
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
        if ($this->segment(1) == config('site.crm')) {
            switch ($this->segment(3)) {
                case 'add':
                    return [
                        'content' => 'required|min:2',
                    ];
                    break;
                case 'view':
                    return [
                        'reply' => 'required|min:2',
                    ];
                    break;
                case 'ticket':
                    return [
                        'title' => 'required|min:2',
                        'content' => 'required|min:2',
                        'fac_id'=>'required|exists:factualy_list,id'
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
