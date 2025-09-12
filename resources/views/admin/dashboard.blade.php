@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="bg-gradient-to-r from-purple-500 to-blue-500 p-3 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h1 class="text-3xl font-bold text-gray-800">Barangay eBudget Transparency</h1>
                    <p class="text-gray-600 mt-1">Welcome, {{ auth('admin')->user()->name }}!</p>
                </div>
            </div>
            
            <!-- Dashboard Search Bar -->
            <div class="relative max-w-md w-full">
                <div class="relative">
                    <input 
                        type="text" 
                        id="dashboardSearch"
                        placeholder="Search dashboard sections..." 
                        class="w-full pl-10 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white shadow-sm"
                        autocomplete="off"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button 
                        type="button" 
                        id="clearDashboardSearch"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors hidden"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Search Results Dropdown -->
                <div id="searchResults" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-lg mt-2 z-50 hidden max-h-64 overflow-y-auto">
                    <div class="p-2">
                        <div class="text-sm text-gray-500 px-3 py-2">Start typing to search dashboard sections...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Budget Summary Cards -->
    <div id="budget-summary" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" data-search-terms="budget summary total spent remaining overview financial">
        <!-- Total Budget Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide mb-2">TOTAL BUDGET</h3>
                    <p class="text-3xl font-bold text-blue-600">₱{{ number_format($totalBudget, 2) }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Spent Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 border-gray-800 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide mb-2">TOTAL SPENT</h3>
                    <p class="text-3xl font-bold text-gray-800">₱{{ number_format($totalSpent, 2) }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 0h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Remaining Budget Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border-l-4 {{ $totalRemaining < 0 ? 'border-red-500' : 'border-green-500' }} hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-600 uppercase tracking-wide mb-2">REMAINING BUDGET</h3>
                    <p class="text-3xl font-bold {{ $totalRemaining < 0 ? 'text-red-600' : 'text-green-600' }}">₱{{ number_format($totalRemaining, 2) }}</p>
                </div>
                <div class="p-3 rounded-full {{ $totalRemaining < 0 ? 'bg-red-100' : 'bg-green-100' }}">
                    @if($totalRemaining < 0)
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    @else
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Active Filters Display -->
    @if(request('month') || request('year') || request('category'))
    <div id="active-filters" class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg" data-search-terms="filters active month year category">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
            </svg>
            <h4 class="text-sm font-medium text-blue-800">Active Filters:</h4>
        </div>
        <div class="mt-2 flex flex-wrap gap-2">
            @if(request('month'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Month: {{ \Carbon\Carbon::create()->month(request('month'))->format('F') }}
                </span>
            @endif
            @if(request('year'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Year: {{ request('year') }}
                </span>
            @endif
            @if(request('category'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Category: {{ request('category') }}
                </span>
            @endif
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 hover:bg-red-200 transition-colors">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear All
            </a>
        </div>
    </div>
    @endif

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Budget Overview Chart -->
        <div id="budget-overview-chart" class="bg-white rounded-2xl shadow-xl p-6" data-search-terms="budget overview chart pie doughnut spending">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 ml-3">Budget Overview</h3>
            </div>
            <div class="relative h-80">
                <canvas id="budgetOverviewChart" class="w-full h-full"></canvas>
            </div>
            <!-- Budget Summary Text -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold text-gray-800">Total Spent:</span> 
                    <span id="spentPercentage" class="text-gray-800 font-bold">{{ $totalBudget > 0 ? number_format(($totalSpent / $totalBudget) * 100, 1) : 0 }}%</span>
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-semibold text-gray-800">Remaining:</span> 
                    <span id="remainingPercentage" class="text-gray-800 font-bold">{{ $totalBudget > 0 ? number_format(($totalRemaining / $totalBudget) * 100, 1) : 0 }}%</span>
                </p>
            </div>
        </div>

        <!-- Category Spending Chart -->
        <div id="spending-by-category" class="bg-white rounded-2xl shadow-xl p-6" data-search-terms="spending category chart bar graph categories">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 ml-3">Spending by Category</h3>
            </div>
            <div class="relative h-80">
                <canvas id="categoryChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Announcements Section -->
    <div id="announcements-section" class="bg-white rounded-2xl shadow-xl p-6 mb-8" data-search-terms="announcements news updates posts notifications">
        <div class="flex items-center mb-6">
            <div class="bg-gradient-to-r from-purple-100 to-pink-100 p-3 rounded-xl">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 ml-3">📢 Announcements</h2>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if ($announcements && $announcements->count())
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Content</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date Posted</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($announcements as $index => $announcement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900 leading-5">{{ $announcement->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 max-w-xs">
                                    <div class="line-clamp-3">{!! nl2br(e(Str::limit($announcement->content, 100))) !!}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6l1 1v9a2 2 0 01-2 2H9a2 2 0 01-2-2V8l1-1z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 font-medium">
                                        {{ $announcement->published_at ? $announcement->published_at->format('F j, Y') : $announcement->created_at->format('F j, Y') }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="bg-gradient-to-br from-purple-100 to-pink-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No announcements found</h3>
                    <p class="text-gray-600">No announcements have been posted yet.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data from backend
        const budgetChart = @json($budgetChart ?? ['labels' => [], 'data' => []]);
        const totalBudget = {{ $totalBudget ?? 0 }};
        const totalSpent = {{ $totalSpent ?? 0 }};
        const totalRemaining = {{ $totalRemaining ?? 0 }};

        // Budget Overview Chart (Doughnut)
        const budgetOverviewChart = new Chart(document.getElementById('budgetOverviewChart'), {
            type: 'doughnut',
            data: {
                labels: ['Total Spent', 'Remaining Budget'],
                datasets: [{
                    data: [totalSpent, totalRemaining > 0 ? totalRemaining : 0],
                    backgroundColor: [
                        '#ef4444', // Red for spent
                        totalRemaining < 0 ? '#dc2626' : '#22c55e' // Dark red for over budget, green for remaining
                    ],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverBorderWidth: 4,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const percentage = totalBudget > 0 ? ((value / totalBudget) * 100).toFixed(1) : 0;
                                return context.label + ': ₱' + value.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Category Chart (Bar Chart)
        if (budgetChart.labels && budgetChart.labels.length > 0) {
            const categoryChart = new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: budgetChart.labels,
                    datasets: [{
                        label: 'Amount (₱)',
                        data: budgetChart.data,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(99, 102, 241, 0.8)',
                            'rgba(236, 72, 153, 0.8)'
                        ],
                        borderColor: [
                            'rgb(59, 130, 246)',
                            'rgb(239, 68, 68)',
                            'rgb(34, 197, 94)',
                            'rgb(168, 85, 247)',
                            'rgb(245, 158, 11)',
                            'rgb(99, 102, 241)',
                            'rgb(236, 72, 153)'
                        ],
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        } else {
            // Show message when no category data
            document.getElementById('categoryChart').parentElement.innerHTML = `
                <div class="flex items-center justify-center h-80 text-gray-500">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="text-gray-500">No category data available</p>
                    </div>
                </div>
            `;
        }

        // Function to update charts when budget data changes
        function updateBudgetCharts(newTotalBudget, newTotalSpent, newTotalRemaining) {
            // Update budget overview chart
            budgetOverviewChart.data.datasets[0].data = [newTotalSpent, newTotalRemaining > 0 ? newTotalRemaining : 0];
            budgetOverviewChart.data.datasets[0].backgroundColor = [
                '#ef4444',
                newTotalRemaining < 0 ? '#dc2626' : '#22c55e'
            ];
            budgetOverviewChart.update();

            // Update percentages
            const spentPercentage = newTotalBudget > 0 ? ((newTotalSpent / newTotalBudget) * 100).toFixed(1) : 0;
            const remainingPercentage = newTotalBudget > 0 ? ((newTotalRemaining / newTotalBudget) * 100).toFixed(1) : 0;
            
            document.getElementById('spentPercentage').textContent = spentPercentage + '%';
            document.getElementById('remainingPercentage').textContent = remainingPercentage + '%';
        }

        // Make function globally available for potential external calls
        window.updateBudgetCharts = updateBudgetCharts;

        // Dashboard Search Functionality
        class DashboardSearch {
            constructor() {
                this.searchInput = document.getElementById('dashboardSearch');
                this.searchResults = document.getElementById('searchResults');
                this.clearButton = document.getElementById('clearDashboardSearch');
                this.currentHighlight = null;
                
                // Define searchable sections
                this.sections = [
                    {
                        id: 'budget-summary',
                        title: 'Budget Summary',
                        description: 'Total budget, spent amount, and remaining budget cards',
                        icon: '💰',
                        keywords: ['budget', 'summary', 'total', 'spent', 'remaining', 'financial', 'overview', 'money']
                    },
                    {
                        id: 'budget-overview-chart',
                        title: 'Budget Overview Chart',
                        description: 'Pie chart showing budget allocation and spending',
                        icon: '📊',
                        keywords: ['budget', 'overview', 'chart', 'pie', 'doughnut', 'spending', 'allocation', 'visual']
                    },
                    {
                        id: 'spending-by-category',
                        title: 'Spending by Category',
                        description: 'Bar chart displaying spending across different categories',
                        icon: '📈',
                        keywords: ['spending', 'category', 'categories', 'bar', 'chart', 'graph', 'breakdown']
                    },
                    {
                        id: 'announcements-section',
                        title: 'Announcements',
                        description: 'Latest announcements and updates',
                        icon: '📢',
                        keywords: ['announcements', 'news', 'updates', 'posts', 'notifications', 'messages']
                    },
                    {
                        id: 'active-filters',
                        title: 'Active Filters',
                        description: 'Currently applied filters for data viewing',
                        icon: '🔍',
                        keywords: ['filters', 'active', 'month', 'year', 'category', 'search']
                    }
                ];
                
                this.initializeEventListeners();
            }

            initializeEventListeners() {
                // Search input events
                this.searchInput.addEventListener('input', (e) => {
                    this.handleSearch(e.target.value);
                });

                this.searchInput.addEventListener('focus', () => {
                    if (this.searchInput.value.trim()) {
                        this.showResults();
                    }
                });

                this.searchInput.addEventListener('blur', (e) => {
                    // Delay hiding to allow for clicks on results
                    setTimeout(() => {
                        this.hideResults();
                    }, 200);
                });

                // Clear button
                this.clearButton.addEventListener('click', () => {
                    this.clearSearch();
                });

                // Keyboard navigation
                this.searchInput.addEventListener('keydown', (e) => {
                    this.handleKeyNavigation(e);
                });

                // Click outside to close
                document.addEventListener('click', (e) => {
                    if (!this.searchInput.contains(e.target) && !this.searchResults.contains(e.target)) {
                        this.hideResults();
                    }
                });
            }

            handleSearch(query) {
                const trimmedQuery = query.trim().toLowerCase();
                
                if (trimmedQuery.length === 0) {
                    this.hideResults();
                    this.clearButton.classList.add('hidden');
                    this.clearHighlight();
                    return;
                }

                this.clearButton.classList.remove('hidden');
                const results = this.searchSections(trimmedQuery);
                this.displayResults(results, trimmedQuery);
            }

            searchSections(query) {
                return this.sections.filter(section => {
                    const titleMatch = section.title.toLowerCase().includes(query);
                    const descriptionMatch = section.description.toLowerCase().includes(query);
                    const keywordMatch = section.keywords.some(keyword => keyword.includes(query));
                    
                    return titleMatch || descriptionMatch || keywordMatch;
                }).sort((a, b) => {
                    // Prioritize title matches
                    const aScore = a.title.toLowerCase().includes(query) ? 2 : 1;
                    const bScore = b.title.toLowerCase().includes(query) ? 2 : 1;
                    return bScore - aScore;
                });
            }

            displayResults(results, query) {
                if (results.length === 0) {
                    this.searchResults.innerHTML = `
                        <div class="p-4">
                            <div class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.5.904-6.13 2.38"></path>
                                </svg>
                                <span class="text-sm">No sections found for "${query}"</span>
                            </div>
                        </div>
                    `;
                } else {
                    this.searchResults.innerHTML = results.map((section, index) => `
                        <div class="search-result-item p-3 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0" 
                             data-section-id="${section.id}" 
                             data-index="${index}">
                            <div class="flex items-center">
                                <span class="text-lg mr-3">${section.icon}</span>
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900 text-sm">${this.highlightMatch(section.title, query)}</div>
                                    <div class="text-xs text-gray-500 mt-1">${this.highlightMatch(section.description, query)}</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    `).join('');

                    // Add click events to results
                    this.searchResults.querySelectorAll('.search-result-item').forEach(item => {
                        item.addEventListener('click', (e) => {
                            const sectionId = e.currentTarget.getAttribute('data-section-id');
                            this.navigateToSection(sectionId);
                        });
                    });
                }
                
                this.showResults();
            }

            highlightMatch(text, query) {
                const regex = new RegExp(`(${query})`, 'gi');
                return text.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
            }

            navigateToSection(sectionId) {
                const section = document.getElementById(sectionId);
                if (section) {
                    // Clear any existing highlights
                    this.clearHighlight();
                    
                    // Add highlight to the target section
                    section.classList.add('search-highlight');
                    this.currentHighlight = section;
                    
                    // Smooth scroll to section
                    section.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    
                    // Hide search results
                    this.hideResults();
                    
                    // Remove highlight after 3 seconds
                    setTimeout(() => {
                        this.clearHighlight();
                    }, 3000);
                    
                    // Show success message
                    this.showNavigationSuccess(sectionId);
                }
            }

            showNavigationSuccess(sectionId) {
                const section = this.sections.find(s => s.id === sectionId);
                if (section) {
                    // Create temporary success message
                    const message = document.createElement('div');
                    message.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
                    message.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Navigated to ${section.title}
                        </div>
                    `;
                    
                    document.body.appendChild(message);
                    
                    // Remove message after 2 seconds
                    setTimeout(() => {
                        message.style.opacity = '0';
                        setTimeout(() => {
                            document.body.removeChild(message);
                        }, 300);
                    }, 2000);
                }
            }

            clearHighlight() {
                if (this.currentHighlight) {
                    this.currentHighlight.classList.remove('search-highlight');
                    this.currentHighlight = null;
                }
            }

            clearSearch() {
                this.searchInput.value = '';
                this.hideResults();
                this.clearButton.classList.add('hidden');
                this.clearHighlight();
                this.searchInput.focus();
            }

            showResults() {
                this.searchResults.classList.remove('hidden');
            }

            hideResults() {
                this.searchResults.classList.add('hidden');
            }

            handleKeyNavigation(e) {
                const items = this.searchResults.querySelectorAll('.search-result-item');
                if (items.length === 0) return;

                let currentIndex = -1;
                items.forEach((item, index) => {
                    if (item.classList.contains('bg-blue-50')) {
                        currentIndex = index;
                    }
                });

                switch (e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        currentIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
                        this.highlightResult(items, currentIndex);
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        currentIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
                        this.highlightResult(items, currentIndex);
                        break;
                    case 'Enter':
                        e.preventDefault();
                        if (currentIndex >= 0 && items[currentIndex]) {
                            const sectionId = items[currentIndex].getAttribute('data-section-id');
                            this.navigateToSection(sectionId);
                        }
                        break;
                    case 'Escape':
                        this.hideResults();
                        this.searchInput.blur();
                        break;
                }
            }

            highlightResult(items, index) {
                items.forEach((item, i) => {
                    if (i === index) {
                        item.classList.add('bg-blue-50');
                    } else {
                        item.classList.remove('bg-blue-50');
                    }
                });
            }
        }

        // Initialize dashboard search
        document.addEventListener('DOMContentLoaded', () => {
            new DashboardSearch();
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the announcement.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-lg',
                cancelButton: 'rounded-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
    </script>

    <style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    mark {
        background-color: #fef08a;
        padding: 2px 4px;
        border-radius: 3px;
        font-weight: 600;
    }
    
    /* Search highlight animation */
    .search-highlight {
        animation: highlightPulse 2s ease-in-out;
        border: 2px solid #3b82f6 !important;
        border-radius: 16px !important;
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3) !important;
    }
    
    @keyframes highlightPulse {
        0%, 100% { 
            transform: scale(1); 
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }
        50% { 
            transform: scale(1.02); 
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.5);
        }
    }
    
    /* Search results styling */
    #searchResults {
        max-height: 300px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }
    
    #searchResults::-webkit-scrollbar {
        width: 6px;
    }
    
    #searchResults::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    #searchResults::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    #searchResults::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Smooth transitions for all sections */
    [data-search-terms] {
        transition: all 0.3s ease;
    }
    </style>
</div>
@endsection