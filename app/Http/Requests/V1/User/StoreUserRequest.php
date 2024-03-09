<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . optional($this->user)->id,
            // 'profile_image' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096', // Adjust file types and size as needed
            'password' => 'required|string|min:6',
            // 'phone_number' => 'nullable|string|max:20',
            // 'address' => 'nullable|string',
            // 'role' => 'required|in:super-admin,vendor,customer,guest',
            'role' => 'null|string',
        ];
    }
}
