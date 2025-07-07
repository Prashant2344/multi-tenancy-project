<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    @if (session('status'))
        <div style="color: green;">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required autofocus>
        </div>
        <div>
            <button type="submit">Send Password Reset Link</button>
        </div>
    </form>
    <p>
        <a href="{{ route('login') }}">Back to Login</a>
    </p>
</body>
</html> 