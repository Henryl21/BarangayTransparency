<form action="{{ route('admin.reset.password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="token" value="{{ $token }}">

    <label for="password">New Password:</label>
    <input type="password" name="password" required>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation" required>

    <button type="submit">Reset Password</button>
</form>
