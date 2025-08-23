@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Create Resolution Sheet</h1>
    <form action="{{ route('user.resolutions.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Content</label>
            <textarea name="content" rows="5" class="w-full border rounded p-2" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Officer Name</label>
            <input type="text" name="officer_name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Department</label>
            <input type="text" name="department" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit for Approval</button>
    </form>
</div>
@endsection
