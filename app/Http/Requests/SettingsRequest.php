<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingsRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email',
        ];

        // Only validate the password, new_password, and confirm_password fields if the checkbox is checked
        if ($this->input('password')) {
            $encryptedPassword = bcrypt($this->input('password'));
            $userId = auth()->user()->id;
            
            $rules['password'] = [
                'required',
                'min:6',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail('The selected password is invalid.');
                    }
                },
            ];

            $rules['new_password'] = 'required|min:6';
            $rules['confirm_password'] = 'required|min:6';
        }
    
        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    // public function withValidator(Validator $validator): void
    // {
    //     $validator->after(function (Validator $validator) {
    //         // Only perform additional validation if the checkbox is checked
    //         if ($this->input('change_password')) {
    //             $userId = Auth::user()->id;
    //             $data = $this->all();

    //             $password = $data['password'] ?? null;
    //             $newPassword = $data['new_password'] ?? null;
    //             $confirmPassword = $data['confirm_password'] ?? null;

    //             // Check if the password is correct for the current user
    //             if ($password && !Auth::attempt(['id' => $userId, 'password' => $password])) {
    //                 $validator->errors()->add('password', 'The current password is incorrect.');
    //             }

    //             // Check if the new password matches the confirmation
    //             if ($newPassword !== $confirmPassword) {
    //                 $validator->errors()->add('confirm_password', 'The new password confirmation does not match.');
    //             }

    //             // Check if the name and email exist for another user
    //             $existingUser = User::where('id', '!=', $userId)
    //                 ->where(function ($query) use ($data) {
    //                     $query->where('name', $data['name'])
    //                         ->orWhere('email', $data['email']);
    //                 })
    //                 ->first();

    //             if ($existingUser) {
    //                 if ($existingUser->name === $data['name']) {
    //                     $validator->errors()->add('name', 'The name is already taken by another user.');
    //                 }

    //                 if ($existingUser->email === $data['email']) {
    //                     $validator->errors()->add('email', 'The email is already taken by another user.');
    //                 }
    //             }
    //         }
    //     });
    // }
}
