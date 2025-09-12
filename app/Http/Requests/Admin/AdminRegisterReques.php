<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to register
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $barangayKeys = array_keys(Admin::getBarangays());
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[a-zA-Z\s\-\.]+$/' // Only letters, spaces, hyphens, and dots
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:admins,email',
                'max:255'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'barangay_role' => [
                'required',
                Rule::in($barangayKeys),
                'unique:admins,barangay_role' // Ensure barangay is not already taken
            ],
            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB max
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'Name can only contain letters, spaces, hyphens, and dots.',
            'name.min' => 'Name must be at least 2 characters long.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol (@$!%*?&).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'barangay_role.required' => 'Please select a barangay role.',
            'barangay_role.in' => 'Please select a valid barangay from the list.',
            'barangay_role.unique' => 'This barangay already has an assigned admin. Please choose a different barangay.',
            'profile_photo.image' => 'Profile photo must be an image file.',
            'profile_photo.mimes' => 'Profile photo must be a JPEG, PNG, JPG, or GIF file.',
            'profile_photo.max' => 'Profile photo must not be larger than 2MB.',
            'profile_photo.dimensions' => 'Profile photo must be at least 100x100 pixels and no larger than 2000x2000 pixels.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'barangay_role' => 'barangay',
            'profile_photo' => 'profile photo',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from name and email
        $this->merge([
            'name' => trim($this->name ?? ''),
            'email' => trim(strtolower($this->email ?? '')),
        ]);
    }
}