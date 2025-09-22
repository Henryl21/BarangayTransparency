@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">

        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
            <i class="fas fa-comment-dots mr-2 text-blue-500"></i>
            My Feedback
        </h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('feedback.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
                + Add Feedback
            </a>
        </div>

        @if($feedbacks->count())
            <ul class="space-y-4">
                @foreach($feedbacks as $feedback)
                    <li class="border rounded-lg p-4 shadow-sm flex justify-between items-center">
                        <div>
                            <p class="text-gray-700">{{ $feedback->message }}</p>
                            <small class="text-gray-500">Sent: {{ $feedback->created_at->diffForHumans() }}</small>
                        </div>

                        <!-- Delete Button -->
                        <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">You haven’t submitted any feedback yet.</p>
        @endif
    </div>
</div>
@endsection
