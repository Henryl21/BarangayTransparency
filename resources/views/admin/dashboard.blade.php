@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center mb-6">
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
    </div>

    <!-- Budget Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg">
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
        <div class="bg-white rounded-2xl shadow-xl p-6">
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
        <div class="bg-white rounded-2xl shadow-xl p-6">
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
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
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
                           
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($announcements as $index => $announcement)
                           
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
    </style>
</div>
@endsection