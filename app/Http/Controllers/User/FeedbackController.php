<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::where('user_id', Auth::id())
            ->latest()
            ->paginate(10); // paginate if you want pages (optional)
        return view('user.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('user.feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('user.feedback.index')->with('success', 'Feedback submitted successfully!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $feedback->delete();

        return redirect()->route('user.feedback.index')->with('success', 'Feedback deleted successfully.');
    }
}
