@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Barangay Information</h2>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center gap-6">
            @if($settings?->logo)
                <img src="{{ asset('storage/'.$settings->logo) }}" 
                     alt="Barangay Logo" class="w-24 h-24 object-cover rounded-full border">
            @else
                <div class="w-24 h-24 flex items-center justify-center bg-gray-200 rounded-full">
                    <span class="text-gray-500 text-sm">No Logo</span>
                </div>
            @endif

            <div>
                <h3 class="text-xl font-semibold">{{ $settings?->barangay_name ?? 'Not Set' }}</h3>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            @if($settings)
                <!-- Edit Info if the current barangay setting exists -->
                <a href="{{ route('admin.barangay_settings.edit', $settings->id) }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                   Edit Info
                </a>
            @else
                <!-- Create Info if the setting does NOT exist -->
                <a href="{{ route('admin.barangay_settings.create') }}"
                   class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600">
                   Create Info
                </a>
            @endif

            <!-- Manage Expenditures -->
            <a href="{{ route('admin.expenditure.index') }}"
               class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
               Manage Expenditures
            </a>

            <!-- Print Reports -->
            <a href="{{ route('admin.reports.print') }}"
               target="_blank"
               class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800">
               Print Expenditures Report
            </a>
        </div>
    </div>
</div>
@endsection
