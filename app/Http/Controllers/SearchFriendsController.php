<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchFriendsController extends Controller
{
    public function index()
    {
        return view('searchFriends.index');
    }
}
