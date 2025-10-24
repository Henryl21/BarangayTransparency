@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Verify OTP</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.verifyOtp') }}">
        @csrf

        <!-- Hidden email field, so user does not enter it -->
        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

        <div class="form-group mb-3">
            <label for="otp">OTP Code</label>
            <input 
                type="text" 
                name="otp" 
                id="otp" 
                class="form-control @error('otp') is-invalid @enderror" 
                value="{{ old('otp') }}" 
                required 
                autofocus
            >
            @error('otp')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>
</div>
@endsection
