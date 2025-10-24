<!-- resources/views/officer/auth/reset-password.blade.php -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('officer.reset.password.submit') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email ?? '' }}">

    <input type="password" name="password" placeholder="New Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    
    <button type="submit">Reset Password</button>
</form>
