@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Search and Table Example</h1>

        <form method="GET" action="{{ route('friendRequest.index') }}">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $searchTerm }}">
            <br>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <br>
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
                                        <form method="POST" action="{{ route('friendRequest.update', $friend->userId) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary mr-2">ACCEPT</button>
                                        </form>
                                        <form method="POST" action="{{ route('friendRequest.update', $friend->userId) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">CANCEL</button>
                                        </form>
                                    @elseif($friend->status == \App\Models\Friend::ACCEPTED)
                                        <form method="POST" action="{{ route('friendRequest.update', $friend->userId) }}" class="d-inline">
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
            <input type="hidden" name="searchTerm" value="{{ $searchTerm }}">
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        // Add event listener to the search input
        var searchInput = document.querySelector('input[name="search"]');

        searchInput.addEventListener('input', function() {
            var searchTerm = searchInput.value.toLowerCase();
            var table = document.querySelector('table');
            var rows = table.getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var name = rows[i].getElementsByTagName('td')[1];

                if (name) {
                    var textValue = name.textContent || name.innerText;
                    if (textValue.toLowerCase().indexOf(searchTerm) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        });
@endsection
