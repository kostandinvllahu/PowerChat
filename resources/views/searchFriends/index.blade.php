@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Search & Connect With People</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        input[type="text"] {
            padding: 6px;
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search and Table Example</h1>

        <input type="text" id="search" class="form-control" placeholder="Search...">
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" id="option1"></td>
                    <td>John Doe</td>
                </tr>
                <tr>
                    <td><input type="checkbox" id="option2"></td>
                    <td>Jane Smith</td>
                </tr>
                <tr>
                    <td><input type="checkbox" id="option3"></td>
                    <td>Mike Johnson</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        // Add event listener to the search input
        var searchInput = document.getElementById('search');
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
</body>
</html>
@endsection