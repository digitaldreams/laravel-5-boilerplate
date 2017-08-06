<?php

namespace App\Http\Requests\Api\Roles;

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
        $id = isset($this->route('roles')->id) ? $this->route('roles')->id : null;
        return [
            'name' => 'required|unique:roles,name,' . $id,
            'slug' => 'required|unique:roles,slug,' . $id,
            'permissions' => 'array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required',
            'name.unique' => 'Name is already taken',
            'slug.required' => 'Slug is required',
            'slug.unique' => 'Slug is already taken'
        ];
    }
}
