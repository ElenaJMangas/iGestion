<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return \Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        return [
            'title' => 'required|unique:projects,title,'.$this->route('id'),
            'description' => 'required',
            'priority' => 'required',
        ];
    }

    public function messages() {
        return [
            'title.regex' => __('general.typeUsername',['num'=>3]),
        ];
    }


}
