<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailAccountVerificationJob;
use App\Models\User;
use App\Models\UserVerificationToken;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use \Illuminate\Support\Str;

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

            $token = Str::random(32);

            UserVerificationToken::where('user_id', $user->id)->update([
                'token' => $token,
            ]);

            $baseUrl = env('APP_URL') . '/verify-account/' . $token;

            $template = 'Welcome ' . $user->name . ' please verify your account so you can log in and start connecting with people! /*Linku*/';
    
            $bodyEmail = str_replace('/*Linku*/', $baseUrl, $template);
            
            $provider = $user->email;
            $subject = 'Verify Account';
            $body = $bodyEmail;

            SendMailAccountVerificationJob::dispatch($provider, $subject, $body);
            
            throw ValidationException::withMessages([
                $this->username() => [__('Your account has not been verified yet, please check your email and verify your account.')],
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
                    return redirect()->route('login')->with('success', 'Your account has been successfully verified.');
                }           
                // Redirect the user to the login page or some other appropriate page
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
