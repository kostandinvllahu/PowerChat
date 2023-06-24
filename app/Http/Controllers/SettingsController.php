<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PreferenceList;
use App\Models\Preference;
use App\Http\Requests\SettingsRequest;

class SettingsController extends Controller
{

    public function getUser()
    {
        return Auth::user();
    }

    public function getPreferences()
    {
        return Preference::all();
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = $this->getUser();
        $settings = User::where('id',$user->id)->first();
        $userPreferences = Preference::where('userId', $user->id)->pluck('preference_id');
        $preferences = PreferenceList::all();
        return view('settings.index', compact('settings','preferences','userPreferences'));
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

    // Delete all existing preferences associated with the user
    $user->preferences()->detach();

    // Add the new preferences for the user
    $preferenceIds = $request->input('preferences');
    $timestamp = now();

    $user->preferences()->detach();

    if (!empty($preferenceIds)) {
        foreach ($preferenceIds as $preferenceId) {
            $user->preferences()->attach($preferenceId, ['created_at' => $timestamp, 'updated_at' => $timestamp]);
        }
    }
    return redirect()->back()->with('success', 'Settings updated successfully.');
}

}
    
