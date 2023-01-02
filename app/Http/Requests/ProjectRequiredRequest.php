<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequiredRequest extends FormRequest
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

                    ];
                    break;
            }

        } elseif ($this->segment(1) == config('site.crm')) {
            return [
                'title' => 'required|min:2',
                'abstract' => 'required|min:2',
                'source' => 'required|min:2',
                'content' => 'required|min:2',
                'type' => 'required|numeric|exists:project_required_type,id',
                'factualy_id' => 'required|numeric|exists:factualy_list,id',
                'supervisor' => 'required|numeric|exists:users,id',
            ];
        }
    }
}
