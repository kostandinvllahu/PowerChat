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

        <table class="table">
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userNames as $userId => $userName)
                    <tr>
                        <td><input type="checkbox" id="option{{ $userId }}"></td>
                        <td>{{ $userName }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
    </script>
@endsection
