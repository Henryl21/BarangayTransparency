<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Approval System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .nav-item {
            transition: all 0.3s ease;
            position: relative;
        }
        .nav-item:hover {
            transform: translateX(5px);
        }
        .nav-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #ffffff;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-right: 10px solid #f3f4f6;
        }
        .logo-glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }
        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        .nav-section {
            margin-bottom: 1rem;
        }
        .nav-section-title {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 1rem;
            margin-bottom: 0.5rem;
        }
        
        /* Notification Toast Styles */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 350px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .status-badge {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
        }
        
        .pending { background-color: #fbbf24; color: #000; }
        .approved { background-color: #10b981; color: #fff; }
        .declined { background-color: #ef4444; color: #fff; }
        
        .btn-action {
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="flex bg-gray-100 min-h-screen">
    <!-- Sidebar -->
    <aside class="w-72 sidebar-gradient shadow-2xl min-h-screen relative">
        <!-- Logo Section -->
        <div class="p-6 border-b border-white border-opacity-20">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-pie text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-xl logo-glow">eBudget</h1>
                    <p class="text-white text-opacity-80 text-sm">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col gap-1 p-4 pb-32 overflow-y-auto" style="max-height: calc(100vh - 200px);">
            <!-- Main Section -->
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" onclick="navigateTo('dashboard')"
                   class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                        <i class="fas fa-tachometer-alt text-lg"></i>
                    </div>
                    <div>
                        <div class="font-medium">Dashboard</div>
                        <div class="text-xs text-white text-opacity-60">Overview & Stats</div>
                    </div>
                </a>
            </div>

            <!-- Budget Management Section -->
            <div class="nav-section">
                <div class="nav-section-title">Budget Management</div>
                
                <!-- Manage Budget -->
                <a href="{{ route('admin.budget.index') }}" onclick="navigateTo('budget')"
                   class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                        <i class="fas fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <div class="font-medium">Manage Budget</div>
                        <div class="text-xs text-white text-opacity-60">Budget Planning</div>
                    </div>
                </a>

                <!-- Manage Expenditures -->
                <a href="{{ route('admin.expenditure.index') }}" onclick="navigateTo('expenditure')"
                   class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                        <i class="fas fa-receipt text-lg"></i>
                    </div>
                    <div>
                        <div class="font-medium">Expenditures</div>
                        <div class="text-xs text-white text-opacity-60">Track Expenses</div>
                    </div>
                </a>
            </div>

            <!-- Administration Section -->
            <div class="nav-section">
                <div class="nav-section-title">Administration</div>
                
                <!-- Officer Approval - ACTIVE -->
                <a href="{{ route('admin.officers.approval') }}" onclick="navigateTo('officer-approval')"
                   class="nav-item active flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 relative">
                        <i class="fas fa-user-check text-lg"></i>
                        <!-- Notification badge for pending approvals -->
                        <div class="notification-badge" id="pendingBadge">3</div>
                    </div>
                    <div>
                        <div class="font-medium">Officer Approval</div>
                        <div class="text-xs text-white text-opacity-60">Approve Officers</div>
                    </div>
                </a>

                <!-- Announcements -->
                <a href="{{ route('admin.announcements.index') }}" onclick="navigateTo('announcements')"
                   class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                        <i class="fas fa-bullhorn text-lg"></i>
                    </div>
                    <div>
                        <div class="font-medium">Announcements</div>
                        <div class="text-xs text-white text-opacity-60">Manage Posts</div>
                    </div>
                </a>
            </div>
        </nav>
            
        <!-- User Profile & Logout -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white border-opacity-20 bg-gradient-to-t from-black from-opacity-20">
            <div class="flex items-center gap-3 mb-4 p-3 bg-white bg-opacity-10 rounded-xl">
                <div class="w-10 h-10 bg-white bg-opacity-30 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div class="flex-1">
                    <div class="text-white font-medium text-sm">Admin User</div>
                    <div class="text-white text-opacity-60 text-xs">System Administrator</div>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('admin.logout') }}" class="w-full" id="logoutForm">
                @csrf
                <button type="button" onclick="logout()" 
                        class="w-full flex items-center justify-center gap-2 bg-red-500 bg-opacity-80 hover:bg-opacity-100 text-white py-3 px-4 rounded-xl transition-all duration-300 font-medium">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-50">
        <!-- Toast Notification Container -->
        <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

        <div class="p-6">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-user-check text-blue-600 mr-3"></i>
                    Officer Approval System
                </h1>
                <p class="text-gray-600">Review and manage officer registration requests</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Pending</h3>
                            <p class="text-3xl font-bold" id="pendingCount">0</p>
                        </div>
                        <i class="fas fa-clock text-3xl opacity-80"></i>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Approved</h3>
                            <p class="text-3xl font-bold" id="approvedCount">0</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl opacity-80"></i>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-red-400 to-red-600 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Declined</h3>
                            <p class="text-3xl font-bold" id="declinedCount">0</p>
                        </div>
                        <i class="fas fa-times-circle text-3xl opacity-80"></i>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Total</h3>
                            <p class="text-3xl font-bold" id="totalCount">0</p>
                        </div>
                        <i class="fas fa-users text-3xl opacity-80"></i>
                    </div>
                </div>
            </div>

            <!-- Approval Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Officer Requests</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Officer Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Submitted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="approvalTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- Table rows will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Sample data - replace with actual data from your backend
        let approvals = [
            {
                id: 1,
                officerName: "John Smith",
                department: "IT Department",
                requestType: "Equipment Request",
                dateSubmitted: "2024-12-01",
                status: "pending"
            },
            {
                id: 2,
                officerName: "Sarah Johnson",
                department: "HR Department",
                requestType: "Leave Request",
                dateSubmitted: "2024-12-02",
                status: "pending"
            },
            {
                id: 3,
                officerName: "Mike Wilson",
                department: "Finance Department",
                requestType: "Budget Approval",
                dateSubmitted: "2024-12-03",
                status: "approved"
            },
            {
                id: 4,
                officerName: "Emily Davis",
                department: "Operations",
                requestType: "Process Change",
                dateSubmitted: "2024-12-04",
                status: "declined"
            },
            {
                id: 5,
                officerName: "David Brown",
                department: "Sales Department",
                requestType: "Client Meeting",
                dateSubmitted: "2024-12-05",
                status: "pending"
            }
        ];

        // Function to show toast notifications
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            let bgClass = 'bg-blue-500';
            let icon = 'fas fa-info-circle';
            
            switch(type) {
                case 'success':
                    bgClass = 'bg-green-500';
                    icon = 'fas fa-check-circle';
                    break;
                case 'error':
                    bgClass = 'bg-red-500';
                    icon = 'fas fa-times-circle';
                    break;
                case 'warning':
                    bgClass = 'bg-yellow-500';
                    icon = 'fas fa-exclamation-triangle';
                    break;
            }
            
            toast.className = `toast ${bgClass} text-white p-4 rounded-lg shadow-lg flex items-center gap-3`;
            toast.innerHTML = `
                <i class="${icon}"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(toast);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }

        // Function to update statistics
        function updateStats() {
            const pending = approvals.filter(item => item.status === 'pending').length;
            const approved = approvals.filter(item => item.status === 'approved').length;
            const declined = approvals.filter(item => item.status === 'declined').length;
            const total = approvals.length;
            
            document.getElementById('pendingCount').textContent = pending;
            document.getElementById('approvedCount').textContent = approved;
            document.getElementById('declinedCount').textContent = declined;
            document.getElementById('totalCount').textContent = total;
            
            // Update sidebar badge
            const badge = document.getElementById('pendingBadge');
            if (pending > 0) {
                badge.textContent = pending;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        // Function to render the table
        function renderTable() {
            const tbody = document.getElementById('approvalTableBody');
            tbody.innerHTML = '';
            
            approvals.forEach((approval, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 transition-colors duration-200';
                
                let statusBadge = '';
                let actionButtons = '';
                
                switch(approval.status) {
                    case 'pending':
                        statusBadge = '<span class="status-badge pending">Pending</span>';
                        actionButtons = `
                            <div class="flex gap-2">
                                <button onclick="approveRequest(${approval.id})" 
                                        class="btn-action bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-sm font-medium flex items-center gap-1">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                                <button onclick="declineRequest(${approval.id})" 
                                        class="btn-action bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm font-medium flex items-center gap-1">
                                    <i class="fas fa-times"></i> Decline
                                </button>
                            </div>
                        `;
                        break;
                    case 'approved':
                        statusBadge = '<span class="status-badge approved">Approved</span>';
                        actionButtons = '<span class="text-gray-500 text-sm">No actions available</span>';
                        break;
                    case 'declined':
                        statusBadge = '<span class="status-badge declined">Declined</span>';
                        actionButtons = `
                            <button onclick="approveRequest(${approval.id})" 
                                    class="btn-action bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm font-medium flex items-center gap-1">
                                <i class="fas fa-redo"></i> Re-approve
                            </button>
                        `;
                        break;
                }
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${index + 1}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${approval.officerName}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${approval.department}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${approval.requestType}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${approval.dateSubmitted}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${statusBadge}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${actionButtons}</td>
                `;
                
                tbody.appendChild(row);
            });
            
            updateStats();
        }

        // Function to approve a request
        function approveRequest(id) {
            const approval = approvals.find(item => item.id === id);
            if (approval) {
                Swal.fire({
                    title: 'Approve Request?',
                    text: `Are you sure you want to approve ${approval.officerName}'s request?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Approve',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        approval.status = 'approved';
                        showToast(`✅ ${approval.officerName}'s request has been approved!`, 'success');
                        renderTable();
                    }
                });
            }
        }

        // Function to decline a request
        function declineRequest(id) {
            const approval = approvals.find(item => item.id === id);
            if (approval) {
                Swal.fire({
                    title: 'Decline Request?',
                    text: `Are you sure you want to decline ${approval.officerName}'s request?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Decline',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        approval.status = 'declined';
                        showToast(`❌ ${approval.officerName}'s request has been declined.`, 'error');
                        renderTable();
                    }
                });
            }
        }

        // Navigation function
        function navigateTo(page) {
            showToast(`Navigating to ${page}...`, 'info');
            // In a real Laravel app, the href attributes will handle navigation
            // This is just for demo purposes in the artifact
        }

        // Logout function with form submission
        function logout() {
            Swal.fire({
                title: 'Logout?',
                text: 'Are you sure you want to logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showToast('Logging out...', 'info');
                    // Submit the logout form
                    document.getElementById('logoutForm').submit();
                }
            });
        }

        // Add active state management from your original sidebar
        function updateActiveNavItem() {
            const currentPath = window.location.pathname;
            const navItems = document.querySelectorAll('.nav-item');
            
            navItems.forEach(item => {
                item.classList.remove('active');
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href.split('/').pop())) {
                    item.classList.add('active');
                }
            });
        }

        // Notification badge update function from your original
        function updateNotificationBadge() {
            const badge = document.getElementById('pendingBadge');
            if (badge) {
                const pendingCount = approvals.filter(item => item.status === 'pending').length;
                if (pendingCount > 0) {
                    badge.textContent = pendingCount;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        // Show approval alert function from your original
        function showApprovalAlert() {
            const pendingCount = approvals.filter(item => item.status === 'pending').length;
            Swal.fire({
                title: 'Pending Approvals',
                text: `You have ${pendingCount} officer applications pending approval.`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Review Now',
                cancelButtonText: 'Later'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Already on the approval page
                    showToast('You are already on the approval page!', 'info');
                }
            });
        }

        // Initialize the table when page loads
        document.addEventListener('DOMContentLoaded', function() {
            renderTable();
            updateActiveNavItem();
            showToast('Welcome to the Officer Approval System!', 'info');
            
            // Update notification badge every 30 seconds (from your original code)
            setInterval(updateNotificationBadge, 30000);
            
            // Auto-hide success message functionality from your original
            const successMessage = document.querySelector('.fixed.top-4');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transform = 'translateX(100%)';
                    setTimeout(() => successMessage.remove(), 300);
                }, 3000);
            }
        });
    </script>
</body>
</html>