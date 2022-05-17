<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        // dd($this->user);
        // $user_id = $this->user->id != null ? $this->user->id : $this->user;
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
                'unique:users,username,'.$this->user
            ],
            'email' => [
                'required',
                'unique:users,email,'.$this->user
            ],
        ];
    }
}
