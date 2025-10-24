@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">My Profile</h2>

    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <div class="mt-4 flex gap-2">
        <a href="{{ route('user.profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Profile</a>

        <form action="{{ route('user.profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete Account</button>
        </form>
    </div>
</div>
@endsection
