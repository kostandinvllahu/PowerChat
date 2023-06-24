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
            'preferences.*' => 'exists:preference_lists,id',
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
}
