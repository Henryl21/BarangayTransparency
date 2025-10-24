<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Show all feedback from all users
    public function index()
    {
        // Use paginate so $feedback->links() works
        $feedback = Feedback::with('user')->latest()->paginate(10);

        return view('admin.feedback.index', compact('feedback'));
    }

    // Delete any feedback
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully.');
    }
}
