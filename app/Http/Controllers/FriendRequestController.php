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
        $userFriends = Friend::where('friendsId', $user->id)->get();
        $users = User::whereIn('id', $userFriends->pluck('userId'))->get();

        return view('friendRequest.index', [
            'users' => $users,
            'userFriends' => $userFriends,
        ]);
    }

    public function update(Request $request, $friendId)
    {
        $user = Auth::user();

        /*
         * fix the problem to update values
         * */
        Friend::where('userId',$friendId)->
            where('userId',$user->id)
            ->set('status',Friend::ACCEPTED);

        return redirect()->back()->with('success', 'Friends accepted successfully.');
    }
}
