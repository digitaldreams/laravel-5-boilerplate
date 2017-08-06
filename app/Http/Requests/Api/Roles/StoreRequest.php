<?php

namespace App\Http\Requests\Api\Roles;

use Dingo\Api\Http\FormRequest;
use Dingo\Api\Http\Response;
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
            'name' => 'required|unique:roles,name',
            'slug' => 'required|unique:roles,slug',
            'permissions' => 'array'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Place Type is required',
            'name.unique' => 'Name is already taken',
            'slug.required' => 'Slug Type is required',
            'slug.unique' => 'Slug is already taken'
        ];
    }
}
