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

<form method="POST" action="{{ route('officer.forgot.password.send') }}">
    @csrf
    <input type="email" name="email" placeholder="Your email" required>
    <button type="submit">Send Reset Link</button>
</form>
test