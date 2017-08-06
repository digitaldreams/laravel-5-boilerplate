<?php

namespace App\Http\Requests\Api\Users;

use Dingo\Api\Http\FormRequest;
use Sentinel;
class UpdateRequest extends FormRequest
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
        $id = isset($this->route('users')->id) ? $this->route('users')->id : null;
        return [
            'email' => 'required|email|unique:users,email,' . $id,
            'first_name' => 'required|max:250',
            'last_name' => 'max:250',
            'role_ids.*' => 'exists:roles,id',
            'phone' => 'required'
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
