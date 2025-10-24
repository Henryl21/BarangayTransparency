@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">Edit Profile</h2>

    <form action="{{ route('user.profile.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label class="block text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                class="w-full border rounded p-2">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                class="w-full border rounded p-2">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">New Password (leave blank if unchanged)</label>
            <input type="password" name="password" class="w-full border rounded p-2">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Changes</button>
        <a href="{{ route('user.profile.show') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
