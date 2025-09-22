@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Barangay Information</h2>

    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.barangay_settings.update', $settings->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Barangay Name <span class="text-red-500">*</span></label>
                <input type="text" name="barangay_name" value="{{ old('barangay_name', $settings->barangay_name) }}"
                       class="w-full border rounded px-3 py-2" required>
                @error('barangay_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

           

          

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Logo</label>
                @if($settings->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$settings->logo) }}" class="w-24 h-24 object-cover rounded-full border">
                    </div>
                @endif
                <input type="file" name="logo" accept="image/*"
                       class="w-full border rounded px-3 py-2">
                @error('logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-teal-500 text-white px-4 py-2 rounded-lg hover:bg-teal-600">
                    Update Barangay Info
                </button>
                <a href="{{ route('admin.barangay_settings.index') }}"
                   class="ml-3 text-gray-700 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
