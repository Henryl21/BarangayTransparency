@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-2xl mx-auto">

        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Expenditure
                </h1>
                <a href="{{ route('admin.expenditure.index') }}" 
                   class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
            <p class="px-6 py-2 text-sm text-gray-600">Update expenditure details and save changes</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <ul class="text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form action="{{ route('admin.expenditure.update', $expenditure->id) }}" 
                  method="POST" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" 
                           value="{{ old('title', $expenditure->title) }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                    <select name="category" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                        <option value="">Select Category</option>
                        @foreach(['Infrastructure','Education','Healthcare','Public Safety','Utilities','Social Services','Transportation','Environment','Administration','Other'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $expenditure->category) === $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Amount (₱)</label>
                    <input type="number" name="amount" step="0.01" min="0" required
                           value="{{ old('amount', $expenditure->amount) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" 
                           value="{{ old('date', $expenditure->date?->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500">
                </div>

               

                <!-- Receipt Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Receipt (Optional)</label>

                    <!-- Show current receipt if exists -->
                    @if($expenditure->receipt)
                        <div class="mb-3">
                            @php
                                $ext = strtolower(pathinfo($expenditure->receipt, PATHINFO_EXTENSION));
                            @endphp

                            @if(in_array($ext, ['jpg','jpeg','png']))
                                <img src="{{ asset('storage/' . $expenditure->receipt) }}" 
                                     alt="Receipt" 
                                     class="w-48 h-48 object-cover border rounded">
                            @elseif($ext === 'pdf')
                                <a href="{{ asset('storage/' . $expenditure->receipt) }}" 
                                   target="_blank" 
                                   class="inline-block px-3 py-2 bg-gray-100 rounded-lg text-sm text-blue-600 hover:bg-gray-200">
                                    View PDF Receipt
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Upload new receipt -->
                    <input type="file" name="receipt" accept="image/*,.pdf"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-emerald-100 file:text-emerald-700
                                  hover:file:bg-emerald-200">
                    <p class="text-xs text-gray-500 mt-1">Upload a new receipt to replace the existing one.</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-6">
                    <button type="submit" 
                            class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                        Update
                    </button>
                    <a href="{{ route('admin.expenditure.index') }}" 
                       class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
