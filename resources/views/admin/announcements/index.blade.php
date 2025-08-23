@extends('layouts.admin')
@section('title', 'Announcements')
@section('content')
<style>
    .announcement-container {
        background: #f8f9fa;
        min-height: calc(100vh - 200px);
        padding: 20px;
    }
    
    .announcement-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        gap: 15px;
    }
    
    .announcement-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #8b5cf6, #a855f7);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }
    
    .announcement-title {
        font-size: 24px;
        font-weight: bold;
        color: #1f2937;
        margin: 0;
        flex-grow: 1;
    }
    
    .btn-new {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
    }
    
    .table-header {
        display: grid;
        grid-template-columns: 60px 1fr 2fr 200px 80px;
        gap: 20px;
        padding: 15px 20px;
        background: white;
        border-radius: 8px 8px 0 0;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 2px;
    }
    
    .announcement-item {
        display: grid;
        grid-template-columns: 60px 1fr 2fr 200px 80px;
        gap: 20px;
        padding: 20px;
        background: white;
        border-bottom: 1px solid #f3f4f6;
        align-items: center;
    }
    
    .announcement-item:last-child {
        border-bottom: none;
        border-radius: 0 0 8px 8px;
    }
    
    .announcement-item:hover {
        background: #f9fafb;
    }
    
    .number-badge {
        width: 28px;
        height: 28px;
        background: #8b5cf6;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }
    
    .announcement-content {
        color: #6b7280;
    }
    
    .announcement-date {
        color: #6b7280;
        font-size: 14px;
    }
    
    .action-buttons {
        display: flex;
        gap: 5px;
    }
    
    .btn-edit {
        background: #f59e0b;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        text-decoration: none;
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .no-announcements {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 8px;
        color: #6b7280;
    }
    
    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #bbf7d0;
    }
</style>

<div class="announcement-container">
    <!-- Header -->
    <div class="announcement-header">
        <div class="announcement-icon">📢</div>
        <h1 class="announcement-title">Announcements</h1>
        <a href="{{ route('admin.announcements.create') }}" class="btn-new">+ New Announcement</a>
    </div>
    
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if ($announcements->count())
        <!-- Table Header -->
        <div class="table-header">
            <div>#</div>
            <div>Title</div>
            <div>Content</div>
            <div>Date Posted</div>
            <div>Actions</div>
        </div>
        
        <!-- Announcements List -->
        @foreach ($announcements as $index => $announcement)
            <div class="announcement-item">
                <!-- Number Badge -->
                <div class="number-badge">{{ $index + 1 }}</div>
                
                <!-- Title -->
                <div style="font-weight: 600; color: #1f2937;">{{ $announcement->title }}</div>
                
                <!-- Content -->
                <div class="announcement-content">{{ Str::limit($announcement->content, 100) }}</div>
                
                <!-- Date -->
                <div class="announcement-date">
                    {{ $announcement->published_at 
                        ? $announcement->published_at->format('F j, Y') 
                        : $announcement->created_at->format('F j, Y') }}
                </div>
                
                <!-- Actions -->
                <div class="action-buttons">
                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" 
                          method="POST" style="display: inline;"
                          onsubmit="return confirm('Delete this announcement?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn-delete">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="no-announcements">
            <div style="font-size: 48px; margin-bottom: 20px;">📢</div>
            <h3>No announcements yet</h3>
            <p>Create your first announcement to get started.</p>
            <a href="{{ route('admin.announcements.create') }}" class="btn-new">Create Announcement</a>
        </div>
    @endif
</div>
@endsection