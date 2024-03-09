<?php

namespace App\Http\Requests\V1\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
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
            // 'id' => 'required',
            // 'user_id' => 'required',
            'vendor_name' => 'required|string|max:255',
            'contact_person_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'verification_status' => 'required|in:verified,pending,in-progress,rejected',
        ];
    }
}
