@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">{{ $resolution->title }}</h1>
    <p class="mb-4 text-gray-600">{{ $resolution->officer_name }} - {{ $resolution->department }}</p>
    <p class="mb-6">{{ $resolution->content }}</p>
    <p class="font-semibold">Status: 
        <span class="{{ $resolution->status == 'approved' ? 'text-green-500' : ($resolution->status == 'declined' ? 'text-red-500' : 'text-yellow-500') }}">
            {{ ucfirst($resolution->status) }}
        </span>
    </p>
</div>
@endsection
