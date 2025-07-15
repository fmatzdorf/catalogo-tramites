<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('user'));
    }

    public function rules(): array
    {
        $user = $this->route('user');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,institutional',
        ];

        // Institution ID is required for institutional users
        if ($this->input('role') === 'institutional') {
            if ($this->user()->role === 'admin') {
                $rules['institution_id'] = 'required|exists:institutions,id';
            } else {
                $rules['institution_id'] = 'required|exists:institutions,id|in:' . $this->user()->institution_id;
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The user name is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'A user with this email already exists.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'role.required' => 'Please select a user role.',
            'role.in' => 'The selected role is invalid.',
            'institution_id.required' => 'Please select an institution for institutional users.',
            'institution_id.exists' => 'The selected institution does not exist.',
            'institution_id.in' => 'You can only update users for your own institution.',
        ];
    }
}
