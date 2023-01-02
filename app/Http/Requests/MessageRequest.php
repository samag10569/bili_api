<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
                case 'view':
                    return [
                        'reply' => 'required|min:2',
                    ];
                    break;
                case 'delete':
                    return [
                        'deleteId' => 'required',
                    ];
                    break;
            }

        } elseif ($this->segment(1) == config('site.admin') || $this->segment(1) == config('site.out')) {
            switch ($this->segment(3)) {
                case 'view':
                    return [
                        'reply' => 'required|min:2',
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
