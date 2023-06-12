<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PasswordExists implements Rule
{
    protected $userId;

    public function __construct()
    {
        $this->userId = Auth::id();
    }

    public function passes($attribute, $value)
    {
        return Auth::validate([
            'id' => $this->userId,
            'password' => $value,
        ]);
    }

    public function message()
    {
        return 'The current password is incorrect.';
    }
}
