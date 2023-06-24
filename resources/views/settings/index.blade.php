@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-4">
            <h2>Settings Panel</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('settings.update', ['setting' => $settings->id]) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" value="{{ old('name', $settings->name) }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" value="{{ old('email', $settings->email) }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="change_password" onchange="togglePasswordFields(this)">
                    <label class="form-check-label" for="change_password">Change Password</label>
                </div> 

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" disabled>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Confirm your password" disabled>
                    @error('new_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter your new password" disabled>
                    @error('confirm_password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


    <div class="form-group">
        <label>Preferences:</label>
    <div style="overflow: auto; max-height: 300px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Option</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($preferences as $preference)
                    <tr>
                        <td class="align-middle">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="preference{{ $preference->id }}" name="preferences[]" value="{{ $preference->id }}" {{ in_array($preference->id, $userPreferences->toArray()) ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td class="align-middle">{{ $preference->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


                
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script>
            function togglePasswordFields(checkbox) {
                var passwordField = document.getElementById('password');
                var newPasswordField = document.getElementById('new_password');
                var confirmPasswordField = document.getElementById('confirm_password');

                passwordField.disabled = !checkbox.checked;
                newPasswordField.disabled = !checkbox.checked;
                confirmPasswordField.disabled = !checkbox.checked;
            }
        </script>
    </body>
    </html>
@endsection
