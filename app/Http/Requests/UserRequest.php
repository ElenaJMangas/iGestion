<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (\Auth::user()->isAdmin() || $this->route('id') == \Auth::user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|regex:/([a-zA-ZÁÉÍÓÚñáéíóú]+[\s]*){3,}/',
            'surname' => 'required|regex:/([a-zA-ZÁÉÍÓÚñáéíóú]+[\s]*){3,}/',
            'username' => 'required|regex:/[a-zA-Z]+[a-zA-Z0-9]{2,}/|unique:users,username,' . $this->route('id'),
            'email' => 'email|required|unique:users,email,' . $this->route('id'),
        ];

        switch ($this->method()) {
            case 'POST': {
                $rules['password'] = 'required|required_with:password_confirmation|same:password_confirmation|regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,40}/|confirmed';
                $rules['password_confirmation'] = 'required_with:password|regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,40}/';
            }
            case 'PUT': {
                $rules['password'] = 'sometimes|required_with:password_confirmation|same:password_confirmation|confirmed';
                $rules['password_confirmation'] = 'required_with:password';
            }
            default:
                break;
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'email.unique' => __('general.emailUnique'),
            'name.regex' => __('general.typename', ['num' => 3]),
            'surname.regex' => __('general.typename', ['num' => 3]),
            'username.regex' => __('general.typeUsername', ['num' => 3]),
            'password.regex' => __('general.typePass', ['num' => 8]),
        ];
    }

}
