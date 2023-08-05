<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailAccountVerificationJob;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserVerificationToken;
use Exception;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            $token = Str::random(32);
    
            $createAccount = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
    
           UserVerificationToken::create([
                'user_id' => $createAccount->id,
                'token' => $token,
                'status' => 'ACTIVE',
            ]);
    
            $baseUrl = env('APP_URL') . 'api/reset-password/' . $token;

            $template = 'Welcome ' . $createAccount->name . ' please verify your account so you can log in and start connecting with people! /*Linku*/';
    
            $bodyEmail = str_replace('/*Linku*/', $baseUrl, $template);
            
            $provider = $createAccount->email;
            $subject = 'Verify Account';
            $body = $bodyEmail;
    
            SendMailAccountVerificationJob::dispatch($provider, $subject, $body);
    
            auth()->login($createAccount); // Log the user in
    
            return $createAccount;
        } catch (Exception $e) {
            Log::error($e); // Log the exception
            throw $e; // Re-throw the exception to allow Laravel's default error handling
        }
    }
}    