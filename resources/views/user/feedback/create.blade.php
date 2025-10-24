@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">

        <h2 class="text-2xl font-bold mb-6">Submit Feedback</h2>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-md">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.feedback.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea id="message" name="message" rows="5"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                          required>{{ old('message') }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('user.feedback.index') }}" class="mr-3">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Send</button>
            </div>
        </form>
    </div>
</div>
@endsection
