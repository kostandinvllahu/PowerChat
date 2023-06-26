@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Search and Table Example</h1>

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
                            <input type="checkbox" id="option{{ $user->id }}" name="friendsIds[]" value="{{ $user->id }}" @if($friendsList->pluck('friendsId')->contains($user->id)) checked @endif>
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
            // Add event listener to the checkboxes
            $('input[type="checkbox"]').on('change', function() {
                var friendId = $(this).val();
                var isChecked = $(this).is(':checked');

                // Send AJAX request to save the friend ID
                $.ajax({
                    url: "{{ route('searchFriends.store') }}",
                    type: "POST",
                    data: {
                        friendId: friendId,
                        isChecked: isChecked
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });

    </script>
@endsection
