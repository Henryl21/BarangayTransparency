<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay eBudget Admin</title>
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
                <a href="{{ route('admin.dashboard') }}" 
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
                <a href="{{ route('admin.budget.index') }}" 
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
                <a href="{{ route('admin.expenditure.index') }}"
                   class="nav-item active flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group">
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
                
                <!-- Officer Approval -->
                <a href="{{ route('admin.officers.approval') }}"
                   class="nav-item flex items-center gap-4 text-white text-opacity-90 hover:text-white hover:bg-white hover:bg-opacity-10 rounded-xl px-4 py-3 group relative">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300 relative">
                        <i class="fas fa-user-check text-lg"></i>
                        <!-- Notification badge for pending approvals -->
                        <div class="notification-badge">3</div>
                    </div>
                    <div>
                        <div class="font-medium">Officer Approval</div>
                        <div class="text-xs text-white text-opacity-60">Approve Officers</div>
                    </div>
                </a>

                <!-- Announcements -->
                <a href="{{ route('admin.announcements.index') }}"
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

           
            
           
      <!-- User Profile & Logout -->
<div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white border-opacity-20 bg-gradient-to-t from-black from-opacity-20">
    <div class="flex items-center gap-3 mb-4 p-3 bg-white bg-opacity-10 rounded-xl">
        <div class="w-10 h-10 rounded-full overflow-hidden bg-white bg-opacity-30 flex items-center justify-center">
            @if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::guard('admin')->user()->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
            @else
                <i class="fas fa-user text-white"></i>
            @endif
        </div>
        <div class="flex-1">
            <div class="text-white font-medium text-sm">
                {{ Auth::guard('admin')->user()->name ?? 'Guest' }}
            </div>
            <div class="text-white text-opacity-60 text-xs">
                System Administrator
            </div>
        </div>
    </div>
    
    <!-- Logout Button -->
    <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
        @csrf
        <button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-red-500 bg-opacity-80 hover:bg-opacity-100 text-white py-3 px-4 rounded-xl transition-all duration-300 font-medium">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </form>
</div>

    </aside>

    <!-- Success Message -->
    @if (session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Content -->
    <main class="flex-1 bg-gray-50">
        @yield('content')
    </main>

    <script>
        // Add active state management
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navItems = document.querySelectorAll('.nav-item');
            
            navItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') && currentPath.includes(item.getAttribute('href').split('/').pop())) {
                    item.classList.add('active');
                }
            });

            // Auto-hide success message
            const successMessage = document.querySelector('.fixed.top-4');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transform = 'translateX(100%)';
                    setTimeout(() => successMessage.remove(), 300);
                }, 3000);
            }

            // Simulate notification updates (you can replace this with actual data)
            function updateNotificationBadge() {
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    // This would typically come from your backend
                    const pendingCount = Math.floor(Math.random() * 10);
                    if (pendingCount > 0) {
                        badge.textContent = pendingCount;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            }

            // Update badge every 30 seconds (adjust as needed)
            setInterval(updateNotificationBadge, 30000);
        });

        // Add click handlers for quick actions
        function showApprovalAlert() {
            Swal.fire({
                title: 'Pending Approvals',
                text: 'You have 3 officer applications pending approval.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Review Now',
                cancelButtonText: 'Later'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.officers.approval') }}";
                }
            });
        }
    </script>
</body>
</html>