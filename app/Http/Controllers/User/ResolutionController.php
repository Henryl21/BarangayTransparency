<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Resolution;
use Illuminate\Http\Request;

class ResolutionController extends Controller
{
    public function create()
    {
        return view('user.resolutions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'officer_name' => 'required',
            'department' => 'required',
        ]);

        Resolution::create($request->all());

        return redirect()->route('user.resolutions.index')
                         ->with('success', 'Resolution submitted for approval.');
    }

    public function index()
    {
        $resolutions = Resolution::latest()->get();
        return view('user.resolutions.index', compact('resolutions'));
    }

    public function show(Resolution $resolution)
    {
        return view('user.resolutions.show', compact('resolution'));
    }
}
