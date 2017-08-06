<?php

namespace App\Http\Requests\Api\Users;

use Dingo\Api\Http\FormRequest;
use Sentienl;
class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->inRole('admin');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|max:250',
            'last_name' => 'max:250',
            'password' => 'required|min:6',
            'role_ids.*' => 'exists:roles,id',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already taken',
            'first_name.required' => 'First Name is required',
            'password.required' => 'Password is required',
            'role_ids.exists' => 'Role is not exists',
            'phone.required' => 'Phone Number is required',
        ];
    }
}
