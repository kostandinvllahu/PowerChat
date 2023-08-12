<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVerificationToken;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->email_verified_at) {
            $this->guard()->logout();
            throw ValidationException::withMessages([
                $this->username() => [__('Your account has not been verified yet.')],
            ]);
        }
    }

    public function verifyAccount($tokenId)
    {
        try {
            $userToken = UserVerificationToken::where([
                ['token', $tokenId],
                ['status', 'ACTIVE']
            ])->first();

            if ($userToken) {
                $user = User::where('id', $userToken->user_id)->first();
                if ($user) {
                    $user->update([
                        'email_verified_at' => now(),
                    ]);
                
                    UserVerificationToken::where('user_id', $user->id)->update([
                        'status' => 'EXPIRED',
                    ]);
                }                

                // Redirect the user to the login page or some other appropriate page
                return redirect()->route('login')->with('success', 'Your account has been successfully verified.');
            } else {
                // Token not found or invalid, handle accordingly
                return redirect()->route('login')->with('error', 'Invalid verification token.');
            }
        } catch (Exception $e) {
            // Log the error or handle it gracefully
            return redirect()->route('login')->with('error', 'An error occurred while verifying your account.');
        }
    }
}
