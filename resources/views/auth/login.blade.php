<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required autofocus>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    <p>
        <a href="{{ route('password.request') }}">Forgot your password?</a>
    </p>
    <p>
        <a href="{{ route('register') }}">Register</a>
    </p>
</body>
</html> 