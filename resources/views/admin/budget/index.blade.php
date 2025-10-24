@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 sm:py-8 px-3 sm:px-4 lg:px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col xs:flex-row xs:items-center xs:justify-between gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="p-2 sm:p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">Income Records</h1>
            </div>
            
            <a href="{{ route('admin.budget.create') }}" 
               class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold text-sm sm:text-base rounded-lg hover:from-emerald-700 hover:to-teal-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg whitespace-nowrap">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                ADD INCOME
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="p-3 bg-blue-100 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Income Records</p>
                        @php
                            $incomeRecords = $budgets->filter(function($budget) {
                                return $budget->type === 'income' || !isset($budget->type);
                            });
                        @endphp
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mt-1">
                            {{ method_exists($budgets, 'total') ? $incomeRecords->count() : $incomeRecords->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start sm:items-center gap-4">
                    <div class="p-3 bg-green-100 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Income Amount</p>
                        <p class="text-xl sm:text-2xl lg:text-3xl font-bold text-green-600 mt-1">
                            ₱{{ number_format($incomeRecords->sum('amount'), 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6 p-4 sm:p-6">
            <form method="GET" action="{{ route('admin.budget.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:gap-4 sm:items-end">
                <div class="flex-1">
                    <label for="search" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Search Income Records</label>
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Search by income title..."
                           class="w-full px-3 sm:px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>
                
                <input type="hidden" name="type" value="income">
                
                <div class="flex gap-2 sm:gap-3">
                    <button type="submit" 
                            class="flex-1 sm:flex-none px-4 py-2.5 bg-green-600 text-white font-semibold text-sm rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all inline-flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span class="hidden sm:inline">Search</span>
                    </button>
                    <a href="{{ route('admin.budget.index') }}?type=income" 
                       class="flex-1 sm:flex-none px-4 py-2.5 bg-gray-300 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all text-center">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 px-4 sm:px-6 py-3 sm:py-4">
                <h2 class="text-lg sm:text-xl font-bold text-white">Income Records Overview</h2>
            </div>

            @php
                $visibleBudgets = $budgets->filter(function($budget) {
                    return $budget->type === 'income' || !isset($budget->type) || $budget->type !== 'expense';
                });
            @endphp

            @if($visibleBudgets->count() > 0)
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 text-white">
                            <tr>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs lg:text-sm font-semibold uppercase tracking-wider">ID</th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs lg:text-sm font-semibold uppercase tracking-wider">Income Title</th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs lg:text-sm font-semibold uppercase tracking-wider">Amount (₱)</th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs lg:text-sm font-semibold uppercase tracking-wider">Date Added</th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs lg:text-sm font-semibold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($visibleBudgets as $budget)
                                <tr class="hover:bg-green-50 transition-colors duration-150">
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $budget->id }}
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $budget->title }}</div>
                                        @if($budget->description)
                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($budget->description, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                        ₱{{ number_format($budget->amount, 2) }}
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $budget->created_at->format('M d, Y') }}
                                        <div class="text-xs text-gray-400">{{ $budget->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-1.5 lg:gap-2">
                                            <a href="{{ route('admin.budget.edit', $budget->id) }}" 
                                               class="inline-flex items-center px-2.5 lg:px-3 py-1.5 bg-orange-500 text-white text-xs font-semibold rounded-md hover:bg-orange-600 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                EDIT
                                            </a>
                                            <form action="{{ route('admin.budget.destroy', $budget->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this income record? This action cannot be undone.')"
                                                        class="inline-flex items-center px-2.5 lg:px-3 py-1.5 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    DELETE
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile & Tablet Cards -->
                <div class="md:hidden">
                    <div class="p-3 sm:p-4 space-y-3 sm:space-y-4">
                        @foreach($visibleBudgets as $budget)
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-3 sm:p-4 border border-green-200 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between mb-3 gap-2">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-semibold text-gray-900 mb-2 truncate">{{ $budget->title }}</h3>
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            Income
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-500 flex-shrink-0">#{{ $budget->id }}</span>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3 mb-3 py-3 border-y border-green-200">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Amount</p>
                                        <p class="text-sm font-bold text-green-600">₱{{ number_format($budget->amount, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Date Added</p>
                                        <p class="text-xs sm:text-sm text-gray-900">{{ $budget->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                @if($budget->description)
                                    <div class="mb-3 pb-3 border-b border-green-200">
                                        <p class="text-xs text-gray-500 mb-1">Description</p>
                                        <p class="text-xs text-gray-700">{{ Str::limit($budget->description, 100) }}</p>
                                    </div>
                                @endif
                                
                                <div class="flex gap-2 pt-2">
                                    <a href="{{ route('admin.budget.edit', $budget->id) }}" 
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2.5 bg-orange-500 text-white text-xs font-semibold rounded-md hover:bg-orange-600 transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.budget.destroy', $budget->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this income record? This action cannot be undone.')"
                                                class="w-full inline-flex items-center justify-center px-3 py-2.5 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600 transition-colors">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                @if(method_exists($budgets, 'hasPages') && $budgets->hasPages())
                <div class="bg-white px-3 sm:px-4 lg:px-6 py-3 lg:py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between flex-col sm:flex-row gap-4">
                        <div class="flex-1 flex justify-between sm:hidden w-full">
                            @if ($budgets->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-xs sm:text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $budgets->appends(['type' => 'income'])->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Previous
                                </a>
                            @endif

                            @if ($budgets->hasMorePages())
                                <a href="{{ $budgets->appends(['type' => 'income'])->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-xs sm:text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Next
                                </a>
                            @else
                                <span class="ml-3 relative inline-flex items-center px-4 py-2 text-xs sm:text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                    Next
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:justify-between w-full">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $budgets->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $budgets->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $visibleBudgets->count() }}</span>
                                    income records
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($budgets->onFirstPage())
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-xs sm:text-sm font-medium text-gray-500 cursor-default">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $budgets->appends(['type' => 'income'])->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-xs sm:text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($budgets->appends(['type' => 'income'])->getUrlRange(1, $budgets->lastPage()) as $page => $url)
                                        @if ($page == $budgets->currentPage())
                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-green-50 text-xs sm:text-sm font-medium text-green-600">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-xs sm:text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($budgets->hasMorePages())
                                        <a href="{{ $budgets->appends(['type' => 'income'])->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-xs sm:text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-xs sm:text-sm font-medium text-gray-500 cursor-default">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-12 sm:py-16 px-4">
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-green-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">No income records found</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-6 max-w-sm mx-auto">
                        @if(request()->has('search'))
                            No income records match your search criteria. Try adjusting your search terms.
                        @else
                            Start tracking your income by creating your first income record.
                        @endif
                    </p>
                    @if(!request()->has('search'))
                        <a href="{{ route('admin.budget.create') }}" 
                           class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold text-sm sm:text-base rounded-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Your First Income
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Hidden expenses section - maintains functionality but not visible -->
        <div style="display: none;">
            @php
                $expenses = $budgets->filter(function($budget) {
                    return $budget->type === 'expense';
                });
            @endphp
            
            @foreach($expenses as $expense)
                <span data-expense-id="{{ $expense->id }}" 
                      data-expense-amount="{{ $expense->amount }}"
                      data-expense-title="{{ $expense->title }}"></span>
            @endforeach
        </div>
    </div>
</div>
@endsection