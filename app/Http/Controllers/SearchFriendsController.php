<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Preference;

class SearchFriendsController extends Controller
{
    public function getUser()
    {
        return Auth::user();
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $this->getUser();
        $userPreferences = Preference::where('userId', $user->id)->pluck('preference_id');

        $similarUserIds = Preference::whereIn('preference_id', $userPreferences)
            ->where('userId', '!=', $user->id)
            ->pluck('userId');

        $searchTerm = $request->input('search', ''); // Get the search term from the request, default to an empty string if not provided

        if(!$searchTerm){
        $userNames = User::whereIn('id', $similarUserIds)
            ->where('name', 'like', '%' . $searchTerm . '%')
            ->pluck('name');
        } else {
            $userNames = User::where('name', 'like', '%' . $searchTerm . '%') ->where('id', '!=', $user->id)->pluck('name');
        }

        return view('searchFriends.index', [
            'similarUserIds' => $similarUserIds,
            'userNames' => $userNames,
            'searchTerm' => $searchTerm, // Pass the search term to the view
        ]);
    }

    public function show(Request $request)
    {
        // Handle the show functionality here if needed
    }
}
