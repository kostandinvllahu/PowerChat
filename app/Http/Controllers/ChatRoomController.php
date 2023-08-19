<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('chatbox.index');
    }

    public function show()
    {

    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
