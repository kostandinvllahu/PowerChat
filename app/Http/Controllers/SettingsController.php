<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\SettingsRequest;

class SettingsController extends Controller
{

    public function getUser()
    {
        return Auth::user();
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = $this->getUser();
        $settings = User::where('id',$user->id)->first();
        return view('settings.index', compact('settings'));
    }
    
    public function update(SettingsRequest $request)
    {
    
    $user = $this->getUser();
    // Update the user's name
    $user->name = $request->input('name');

    // Update the user's email
    $user->email = $request->input('email');

    // Update the user's password if it's provided
    if ($request->filled('password')) {
        $user->password = bcrypt($request->input('confirm_password'));
    }

    // Save the updated user
    $user->save();

    return redirect()->back()->with('success', 'Settings updated successfully.');
}

}
