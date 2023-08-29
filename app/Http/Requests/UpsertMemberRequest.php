<?php

namespace App\Http\Requests;

use App\Models\Member;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpsertMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:50'],
            'password' => ['nullable', 'string'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50'],
            'phone_number' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', Rule::in(Member::$gender)],
            'status' => ['required', Rule::in(Member::$status)],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'date_of_birth' => 'Date of Birth',
            'gender' => 'Gender',
            'status' => 'Status',
        ];
    }
}
