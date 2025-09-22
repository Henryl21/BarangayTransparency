<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::where('user_id', Auth::id())->latest()->get();
        return view('user.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('user.feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback submitted!');
    }

    public function destroy($id)
    {
        $feedback = Feedback::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $feedback->delete();

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback deleted successfully.');
    }
}
