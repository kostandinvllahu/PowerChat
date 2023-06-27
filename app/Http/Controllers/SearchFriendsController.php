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

        $searchTerm = $request->input('searchTerm', '');

        $totalFriendsIds = Friend::where('userId', $userId)->pluck('friendsId');

       if (!empty($searchTerm)) {
         $totalFriendsIds = $totalFriendsIds->toArray(); // Convert collection to array
         $friendIds = $friendIds; // Assuming it's already an array

            // Merge the two arrays and remove duplicates
          $totalArray = array_unique(array_merge($totalFriendsIds, $friendIds));

          Friend::where('userId', $userId)->delete();

            foreach ($totalArray as $friendId) {
                Friend::create([
                    'userId' => $userId,
                    'friendsId' => $friendId,
                    'status' => Friend::PENDING,
                ]);
            }
         } else {

            $totalFriendsIds = $totalFriendsIds->toArray(); // Convert collection to array
            $friendIds = $friendIds; // Assuming it's already an array

            // Merge the two arrays and remove duplicates
            $totalArray = array_unique(array_merge($totalFriendsIds, $friendIds));

            Friend::where('userId', $userId)->delete();

            foreach ($totalArray as $friendId) {
                Friend::create([
                    'userId' => $userId,
                    'friendsId' => $friendId,
                    'status' => Friend::PENDING,
                ]);
         }
    }
        return redirect()->back()->with('success', 'Selected friends saved successfully.');
    }

    public function destroy($friendId)
    {
        $userId = Auth::id();

        Friend::where('userId', $userId)
            ->where('friendsId', $friendId)
            ->delete();

        return redirect()->back()->with('success', 'Friend removed successfully.');
    }


}
