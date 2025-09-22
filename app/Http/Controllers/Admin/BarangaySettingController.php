<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangaySettingController extends Controller
{
    // Display settings (index)
    public function index()
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        // ✅ Only fetch the barangay settings for the logged-in barangay
        $settings = BarangaySetting::where('barangay_role', $barangayRole)->first();

        return view('admin.barangay_settings.index', compact('settings'));
    }

    // Show form to create new settings
    public function create()
    {
        return view('admin.barangay_settings.create');
    }

    // Store new settings
    public function store(Request $request)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        $data = $request->validate([
            'barangay_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        // Auto-fill barangay_role from logged-in admin
        $data['barangay_role'] = $barangayRole;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        BarangaySetting::create($data);

        return redirect()->route('admin.barangay_settings.index')
                         ->with('success', 'Barangay Information created successfully!');
    }

    // Show form to edit existing settings
    public function edit($id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        // ✅ Ensure user can only edit their own barangay settings
        $settings = BarangaySetting::where('barangay_role', $barangayRole)->findOrFail($id);

        return view('admin.barangay_settings.edit', compact('settings'));
    }

    // Update existing settings
    public function update(Request $request, $id)
    {
        $currentAdmin = Auth::guard('admin')->user();
        $barangayRole = $currentAdmin->barangay_role;

        // ✅ Ensure user can only update their own barangay settings
        $settings = BarangaySetting::where('barangay_role', $barangayRole)->findOrFail($id);

        $data = $request->validate([
            'barangay_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        // Always keep barangay_role of logged-in admin
        $data['barangay_role'] = $barangayRole;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $settings->update($data);

        return redirect()->route('admin.barangay_settings.index')
                         ->with('success', 'Barangay Information updated successfully!');
    }
}
