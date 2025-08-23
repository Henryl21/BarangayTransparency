@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Income Record
                    </h1>
                    <a href="{{ route('admin.budget.index') }}" 
                       class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>
                <p class="text-sm text-gray-600 mt-1">Update income details and save changes</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-red-800 mb-2">Please correct the following errors:</h3>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form action="{{ route('admin.budget.update', $budget->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Income Title
                            </span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title"
                               value="{{ old('title', $budget->title) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors placeholder-gray-400"
                               placeholder="Enter income title (e.g., Salary, Freelance, Business Revenue)"
                               required>
                    </div>

                    <!-- Hidden Type Field - Always Income -->
                    <input type="hidden" name="type" value="income">

                    <!-- Type Display (Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                Record Type
                            </span>
                        </label>
                        <div class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-green-50">
                            <div class="flex items-center">
                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    Income
                                </span>
                                <span class="ml-3 text-sm text-gray-600">This record is categorized as income</span>
                            </div>
                        </div>
                    </div>

                    <!-- Amount Field -->
                    <div>
                        <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                Income Amount (₱)
                            </span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-green-600 font-medium">₱</span>
                            <input type="number" 
                                   name="amount" 
                                   id="amount"
                                   value="{{ old('amount', $budget->amount) }}"
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors placeholder-gray-400"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0"
                                   required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Enter the income amount in Philippine Pesos</p>
                    </div>

                    <!-- Description Field (Optional) -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Description (Optional)
                            </span>
                        </label>
                        <textarea name="description" 
                                  id="description"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors placeholder-gray-400 resize-none"
                                  placeholder="Add any additional notes about this income...">{{ old('description', $budget->description ?? '') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Optional: Add details about the source or nature of this income</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 mt-6 border-t border-gray-200">
                    <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Income Record
                    </button>
                    
                    <a href="{{ route('admin.budget.index') }}"
                       class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Information Card -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-green-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-green-800 mb-1">Income Record Management</h3>
                    <ul class="text-sm text-green-700 space-y-1">
                        <li>• This form is specifically for editing income records only</li>
                        <li>• Use clear, descriptive titles for easy identification</li>
                        <li>• All changes are saved immediately after clicking Update</li>
                        <li>• Add descriptions to provide context for future reference</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection