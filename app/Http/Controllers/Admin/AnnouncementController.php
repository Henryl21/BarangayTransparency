<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the announcements.
     */
    public function index()
    {
        // Only show announcements from the logged-in admin's barangay
        $announcements = Announcement::where('barangay_role', auth('admin')->user()->barangay_role)
                                     ->latest()
                                     ->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created announcement in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create([
            'title'         => $request->title,
            'content'       => $request->content,
            'barangay_role' => auth('admin')->user()->barangay_role, // ✅ Save barangay
            'published_at'  => now(),
        ]);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement created successfully.');
    }

    /**
     * Show the form for editing the specified announcement.
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Optional: Ensure only admins from the same barangay can edit
        if ($announcement->barangay_role !== auth('admin')->user()->barangay_role) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified announcement in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement = Announcement::findOrFail($id);

        // Optional: Restrict update to barangay owner
        if ($announcement->barangay_role !== auth('admin')->user()->barangay_role) {
            abort(403, 'Unauthorized action.');
        }

        $announcement->update([
            'title'   => $request->title,
            'content' => $request->content,
            // ✅ Do NOT overwrite barangay_role (keep original)
        ]);

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement updated successfully.');
    }

    /**
     * Remove the specified announcement from storage.
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Optional: Restrict delete to barangay owner
        if ($announcement->barangay_role !== auth('admin')->user()->barangay_role) {
            abort(403, 'Unauthorized action.');
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement deleted successfully.');
    }
}
