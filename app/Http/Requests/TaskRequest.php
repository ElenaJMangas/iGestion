<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required|regex:/[a-zA-Z]+[a-zA-Z0-9]{2,}/',
            'description' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ];
    }

    public function messages() {
        return [
            'title.regex' => __('general.typeUsername',['num'=>3]),
        ];
    }

}
