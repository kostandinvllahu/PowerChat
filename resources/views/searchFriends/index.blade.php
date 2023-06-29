@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Search Friends With Similar Preferences</h1>

        <form method="GET" action="{{ route('searchFriends.index') }}">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ $searchTerm }}">
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
                @foreach ($users as $user)
                    <tr>
                        <td>
                            @if($friendsList->pluck('friendsId')->contains($user->id))
                                <button type="button" class="btn btn-danger remove-friend" data-friend-id="{{ $user->id }}">Remove</button>
                            @else
                                <input type="checkbox" class="friend-checkbox" id="option{{ $user->id }}" name="friendsIds[]" value="{{ $user->id }}">
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if($friendsList->pluck('friendsId')->contains($user->id))
                                {{ implode(', ', $friendsList->where('friendsId', $user->id)->pluck('status')->toArray()) }}
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <input type="hidden" name="searchTerm" value="{{ $searchTerm }}">
            <button type="submit" class="btn btn-primary">Save Selected</button>
        </form>
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

        $(document).ready(function() {
            $('.remove-friend').on('click', function() {
                var friendId = $(this).data('friend-id');

                // Confirmation dialog
                if (confirm('Are you sure you want to remove this friend?')) {
                    // Send the DELETE request
                    $.ajax({
                        url: "{{ route('searchFriends.destroy', '') }}/" + friendId,
                        type: "POST",
                        data: {
                            _method: "DELETE",
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            console.log(error);
                        }
                    });
                }
            });
        });

    </script>
@endsection
