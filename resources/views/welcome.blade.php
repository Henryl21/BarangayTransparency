<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Barangay eBudget Transparency System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'primary-blue': '#1e40af',
                            'secondary-green': '#059669',
                            'accent-gold': '#d97706'
                        }
                    }
                }
            }
        </script>
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
        <!-- Header with Navigation -->
        <header class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-primary-blue/90 to-secondary-green/90"></div>
            <div class="relative z-10 container mx-auto px-6 py-8">
                <div class="flex flex-col lg:flex-row justify-between items-start gap-8">
                    <!-- Left Side: Navigation -->
                    <div class="lg:flex-1">
                        @if (Route::has('login'))
                            <div class="flex flex-col sm:flex-row gap-4">
                                @guest
                                    <!-- Show Login and Register for guests only -->
                                    <a href="{{ route('login') }}" class="bg-white/20 backdrop-blur-sm border border-white/30 text-white px-6 py-3 rounded-lg hover:bg-white/30 transition-all duration-300 font-semibold text-center">
                                        Log in
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="bg-accent-gold/90 border border-accent-gold text-white px-6 py-3 rounded-lg hover:bg-accent-gold transition-all duration-300 font-semibold text-center">
                                            Register
                                        </a>
                                    @endif
                                @endguest
                            </div>
                        @endif
                    </div>

                    <!-- Right Side: Hero Content -->
                    <div class="flex-1 text-white">
                        <div class="max-w-2xl">
                            <h1 class="text-4xl lg:text-6xl font-bold mb-6 leading-tight">
                                Barangay <span class="text-accent-gold">eBudget</span><br>
                                Transparency System
                            </h1>
                            <p class="text-xl lg:text-2xl mb-8 opacity-90">
                                Promoting accountability and transparency in local government financial management
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                                    <span class="font-semibold">Real-time Budget Tracking</span>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                                    <span class="font-semibold">Public Access</span>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                                    <span class="font-semibold">Data-driven Decisions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Features Section -->
        <main class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-4">Transparent Governance at Your Fingertips</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">Our comprehensive system ensures every peso is accounted for and every project is tracked from planning to completion.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1: Budget Analytics -->
                    <a href="/budget-analytics" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-primary-blue/10 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-primary-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Budget Analytics</h3>
                        <p class="text-gray-600">Detailed insights into budget allocation, spending patterns, and financial performance with interactive charts and reports.</p>
                    </a>

                    <!-- Feature 2: Public Transparency -->
                    <a href="/public-transparency" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-secondary-green/10 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-secondary-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Transparency</h3>
                        <p class="text-gray-600">Open access to budget information, expenditures, and project updates to ensure complete transparency in governance.</p>
                    </a>

                    <!-- Feature 3: Real-time Updates -->
                    <a href="/real-time-updates" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-accent-gold/10 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-accent-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Real-time Updates</h3>
                        <p class="text-gray-600">Live tracking of projects, expenditures, and budget utilization with automated notifications and alerts.</p>
                    </a>

                    <!-- Feature 4: Audit Trail -->
                    <a href="/audit-trail" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Audit Trail</h3>
                        <p class="text-gray-600">Complete audit trail of all financial transactions and decisions with user accountability and document management.</p>
                    </a>

                    <!-- Feature 5: Citizen Feedback -->
                    <a href="/citizen-feedback" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Citizen Feedback</h3>
                        <p class="text-gray-600">Interactive platform for citizens to provide feedback, suggestions, and report concerns about budget utilization.</p>
                    </a>

                    <!-- Feature 6: Secure Access -->
                    <a href="/secure-access" class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Secure Access</h3>
                        <p class="text-gray-600">Role-based access control ensuring data security while maintaining transparency and proper authorization levels.</p>
                    </a>
                </div>
            </div>
        </main>

        <!-- Statistics Section -->
        <section class="py-20 bg-gradient-to-r from-primary-blue to-secondary-green">
            <div class="container mx-auto px-6">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
                    <div class="space-y-2">
                        <div class="text-4xl font-bold">₱2.5M</div>
                        <div class="text-xl opacity-90">Monthly Budget</div>
                    </div>
                    <div class="space-y-2">
                        <div class="text-4xl font-bold">45</div>
                        <div class="text-xl opacity-90">Active Projects</div>
                    </div>
                    <div class="space-y-2">
                        <div class="text-4xl font-bold">98%</div>
                        <div class="text-xl opacity-90">Transparency Rate</div>
                    </div>
                    <div class="space-y-2">
                        <div class="text-4xl font-bold">1,200+</div>
                        <div class="text-xl opacity-90">Registered Citizens</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-20">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-8">Ready to Experience Transparent Governance?</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Join thousands of citizens who are actively monitoring and participating in their local government's financial decisions.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-primary-blue text-white px-8 py-4 rounded-lg hover:bg-blue-700 transition-colors font-semibold text-lg">
                        Explore Budget Data
                    </button>
                    <button class="border-2 border-secondary-green text-secondary-green px-8 py-4 rounded-lg hover:bg-secondary-green hover:text-white transition-colors font-semibold text-lg">
                        Download Reports
                    </button>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-12">
            <div class="container mx-auto px-6">
                <div class="grid md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Barangay eBudget System</h3>
                        <p class="text-gray-400">Promoting transparency and accountability in local government financial management through innovative technology solutions.</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">Budget Reports</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Project Updates</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Public Announcements</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contact Information</h4>
                        <div class="space-y-2 text-gray-400">
                            <p>Barangay Hall</p>
                            <p>Bacolod City, Western Visayas</p>
                            <p>Phone: (034) 123-4567</p>
                            <p>Email: ebudget@barangay.gov.ph</p>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 Barangay eBudget Transparency System. All rights reserved.</p>
                    <p class="mt-2">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                </div>
            </div>
        </footer>

        <script>
            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        </script>
    </body>
</html>