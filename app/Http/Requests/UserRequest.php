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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'prefixname' => [
                'required',
            ],
            'firstname' => [
                'required',
                'string',
                'max:20'
            ],
            'middlename' => [
                'required',
                'string',
                'max:20'
            ],
            'lastname' => [
                'required',
                'string',
                'max:20'
            ],
            'suffixname' => [
                'max:3'
            ],
            'username' => [
                'required',
                'unique:users,username'
            ],
            'email' => [
                'required',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'min:6'
            ]
        ];
    }
}
