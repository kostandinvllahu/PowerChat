<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $searchTerm = $request->input('search', '');

        if ($searchTerm) {
            $userIds = User::where('name', 'like', '%' . $searchTerm . '%')
                ->where('id', '!=', $user->id)
                ->pluck('id');

            $userFriends = Friend::whereIn('userId', $userIds)
                ->where('friendsId', $user->id)
                ->whereNotIn('status', [Friend::REJECTED, Friend::BLOCKED, Friend::BLOCKER])
                ->get();

            $users = User::whereIn('id', $userFriends->pluck('userId'))->get();
        } else {
            $userFriends = Friend::where('friendsId', $user->id)
                ->whereNotIn('status', [Friend::REJECTED, Friend::BLOCKED, Friend::BLOCKER])
                ->get();

            $users = User::whereIn('id', $userFriends->pluck('userId'))->get();
        }

        return view('friendRequest.index', [
            'users' => $users,
            'userFriends' => $userFriends,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function update(Request $request, $friendId, $option)
    {
      
    //dd($option);
    $user = Auth::user();

    $query = Friend::where('userId', $friendId)
        ->where('friendsId', $user->id);

    // Execute the update
    if($option == '1') {
    $query->update(['status' => Friend::ACCEPTED]);

    Friend::create([
        'userId' => $user->id,
        'friendsId' => $friendId,
        'status' => Friend::ACCEPTED,
    ]);
    $message = 'Friends accepted successfully.';
}

    if($option == '2') {
        $query->delete();
        $message = 'Friend request rejected successfully.';
    }

    if($option == '3') {
        $query->delete();
        $message = 'Friend unfollowed successfully.';
    }

    return redirect()->back()->with('success', $message);
    }  
}