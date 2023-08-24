<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:50', 'unique:members'],
            'password' => ['required', 'string'],
            'email' => ['required', 'email', 'max:50', 'unique:members'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'phone_number' => ['required', 'string', 'max:50'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Phone Number',
            'date_of_birth' => 'Date of Birth',
            'gender' => 'Gender',
        ];
    }
}
