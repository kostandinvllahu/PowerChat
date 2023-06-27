@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Search and Table Example</h1>

        <form method="GET" action="{{ route('searchFriends.index') }}">
            <input type="text" name="search" class="form-control" placeholder="Search..." >
            <br>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <br>

        <form method="POST" action="{{ route('searchFriends.store') }}">
            @csrf
            <table class="table">
                <thead>
                <tr>
                    <th>Option</th>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            @foreach($userFriends as $friend)
                                @if($friend->userId == $user->id)
                                    @if($friend->status == \App\Models\Friend::PENDING)
                                        <form method="POST" action="{{ route('friendRequest.update', $friend->id) }}" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-primary mr-2">ACCEPT</button>
                                        </form>
                                        <form method="POST" action="{{ route('friendRequest.update', $friend->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">CANCEL</button>
                                        </form>
                                    @elseif($friend->status == \App\Models\Friend::ACCEPTED)
                                        <form method="POST" action="{{ route('friendRequest.update', $friend->id) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger">BLOCK</button>
                                        </form>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @foreach($userFriends as $friend)
                                @if($friend->userId == $user->id)
                                    {{ $friend->status }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <input type="hidden" name="searchTerm" value="">
            <button type="submit" class="btn btn-primary">Save Selected</button>
        </form>
    </div>
@endsection
