@extends('layouts.admin')

@section('title', 'Announcements')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📢 Announcements</h2>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary shadow-sm">
            + Create Announcement
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($announcements->count())
        <div class="table-responsive">
            <table class="table table-hover table-bordered shadow-sm rounded">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Date Posted</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($announcements as $index => $announcement)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td class="fw-semibold">{{ $announcement->title }}</td>
                            <td style="white-space: normal; max-width: 400px; word-wrap: break-word; max-height: 150px; overflow-y: auto;">
                                {!! nl2br(e($announcement->content)) !!}
                            </td>
                            <td>{{ $announcement->published_at ? $announcement->published_at->format('F j, Y') : $announcement->created_at->format('F j, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-warning me-1">
                                    Edit
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center shadow-sm">
            No announcements found.
        </div>
    @endif
</div>
@endsection
