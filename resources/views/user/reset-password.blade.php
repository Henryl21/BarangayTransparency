<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>

        @if (session('success'))
            <div style="color: green;">
                {{ session('success') }}
            </div>
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

        <form method="POST" action="{{ route('user.reset.password.submit') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email ?? '' }}">

            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
