@extends('layouts.user')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">My Resolutions</h1>
    <table class="w-full border-collapse border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resolutions as $res)
            <tr>
                <td class="border px-4 py-2">{{ $res->title }}</td>
                <td class="border px-4 py-2">{{ ucfirst($res->status) }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('user.resolutions.show', $res) }}" class="text-blue-500">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
