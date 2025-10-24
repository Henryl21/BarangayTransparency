<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password</title>
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4">Reset Password</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.reset.password.update') }}">
        @csrf

        <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">
        <input type="hidden" name="token" value="{{ old('token', $token ?? '') }}">

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                required
                autocomplete="new-password"
            >
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-control"
                required
                autocomplete="new-password"
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>
</div>
</body>
</html>
