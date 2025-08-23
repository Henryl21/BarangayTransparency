@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 p-6">
    <div class="max-w-lg mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                Add New Budget
            </h1>
            <p class="text-gray-600">Create a new budget entry to track your finances</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-2xl shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300">
            <form action="{{ route('admin.budget.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title Field -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Title
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 bg-gray-50 focus:bg-white placeholder-gray-400" 
                        placeholder="Enter budget title..."
                        required
                    >
                </div>

                <!-- Amount Field -->
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Amount (₱)
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500 font-medium">₱</span>
                        <input 
                            type="number" 
                            name="amount" 
                            step="0.01" 
                            class="w-full border-2 border-gray-200 p-3 pl-8 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 bg-gray-50 focus:bg-white placeholder-gray-400" 
                            placeholder="0.00"
                            required
                        >
                    </div>
                </div>

                {{-- Automatically set as income --}}
                <input type="hidden" name="type" value="income">

                <!-- Income Badge -->
                <div class="flex items-center justify-center">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                        Income Entry
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a 
                        href="{{ route('admin.budget.index') }}" 
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all duration-200 hover:scale-105"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Cancel
                    </a>
                    
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-8 py-3 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 focus:ring-4 focus:ring-indigo-200"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Budget
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                All budget entries are automatically categorized as income
            </p>
        </div>
    </div>
</div>

<style>
    /* Custom animations and effects */
    .group input:focus + label,
    .group input:valid + label {
        transform: translateY(-0.5rem);
        font-size: 0.75rem;
    }
    
    /* Hover effects for form fields */
    .group:hover input {
        border-color: #6366f1;
    }
    
    /* Gradient text animation */
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    h1 {
        background-size: 200% 200%;
        animation: gradient 3s ease infinite;
    }
    
    /* Subtle pulse animation for the icon */
    .inline-flex.w-16.h-16 {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
</style>
@endsection