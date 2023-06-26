<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddFriendsRequest;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Preference;

class SearchFriendsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $userPreferences = Preference::where('userId', $user->id)->pluck('preference_id');

        $similarUserIds = Preference::whereIn('preference_id', $userPreferences)
            ->where('userId', '!=', $user->id)
            ->pluck('userId');

        $searchTerm = $request->input('search', '');

        if ($searchTerm) {
            $users = User::where('name', 'like', '%' . $searchTerm . '%')
                ->where('id', '!=', $user->id)
                ->get();
        } else {
            $users = User::whereIn('id', $similarUserIds)->get();
        }

        $friendsList = Friend::where('status', Friend::PENDING)
            ->where('userId',$user->id)
            ->get();

        return view('searchFriends.index', [
            'users' => $users,
            'friendsList' => $friendsList,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function store(AddFriendsRequest $request)
    {
        $userId = Auth::id();
        $friendIds = $request->input('friendsIds', []);

        Friend::where('userId',$userId)->delete();

        foreach ($friendIds as $friendId) {
            Friend::create([
                'userId' => $userId,
                'friendsId' => $friendId,
                'status' => Friend::PENDING,
            ]);
        }

        return redirect()->back()->with('success', 'Selected friends saved successfully.');
    }
}
