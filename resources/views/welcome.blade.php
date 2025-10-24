<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barangay eBudget Transparency System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
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
        
        .hero-background {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }
        
        .slideshow-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 2s ease-in-out;
        }
        
        .slide.active {
            opacity: 1;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.8) 0%, rgba(5, 150, 105, 0.7) 100%);
            z-index: 2;
        }
        
        .hero-content {
            position: relative;
            z-index: 3;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .stagger-animation {
            animation: fadeInUp 1s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .stagger-animation:nth-child(1) { animation-delay: 0.2s; }
        .stagger-animation:nth-child(2) { animation-delay: 0.4s; }
        .stagger-animation:nth-child(3) { animation-delay: 0.6s; }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .pulse-glow {
            box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.7);
            animation: pulse-gold 2s infinite;
        }
        
        @keyframes pulse-gold {
            0% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(217, 119, 6, 0); }
            100% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0); }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
    
    <!-- Header with Top Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/10 backdrop-blur-md border-b border-white/20">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-accent-gold rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 8h6m-6 4h6m0 4h6"></path>
                        </svg>
                    </div>
                    <span class="text-white font-bold text-lg">Barangay Ebudget Transparency</span>
                </div>
                
                <!-- Login/Register Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="/user/login" 
                       class="text-white hover:text-accent-gold transition-colors duration-300 font-medium px-4 py-2 rounded-lg hover:bg-white/10">
                        Log in
                    </a>
                    <a href="/user/register" 
                       class="bg-accent-gold hover:bg-accent-gold/90 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 pulse-glow">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Background Slideshow -->
    <header class="hero-background">
        <!-- Background Slideshow -->
        <div class="slideshow-container">
            <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
        </div>
        
        <!-- Overlay -->
        <div class="hero-overlay"></div>
        
        <!-- Hero Content -->
        <div class="hero-content min-h-screen flex items-center justify-center">
            <div class="container mx-auto px-6 text-center text-white">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-5xl lg:text-7xl font-bold mb-8 leading-tight stagger-animation">
                        Barangay <span class="text-accent-gold">eBudget</span><br>
                        <span class="text-4xl lg:text-5xl">Transparency System</span>
                    </h1>
                    <p class="text-xl lg:text-2xl mb-12 opacity-90 max-w-3xl mx-auto stagger-animation">
                        Promoting accountability and transparency in local government financial management through innovative digital solutions
                    </p>
                    
                    <!-- Feature Pills -->
                    <div class="flex flex-wrap justify-center gap-4 mb-12 stagger-animation">
                        <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full border border-white/30 floating-animation">
                            <span class="font-semibold">Real-time Budget Tracking</span>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full border border-white/30 floating-animation" style="animation-delay: 1s;">
                            <span class="font-semibold">Public Access</span>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full border border-white/30 floating-animation" style="animation-delay: 2s;">
                            <span class="font-semibold">Data-driven Decisions</span>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 justify-center stagger-animation">
                        <button class="bg-accent-gold hover:bg-accent-gold/90 text-white px-8 py-4 rounded-lg transition-all duration-300 font-semibold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105">
                            Explore Budget Data
                        </button>
                        <button class="bg-white/20 backdrop-blur-sm border-2 border-white/50 text-white px-8 py-4 rounded-lg hover:bg-white/30 transition-all duration-300 font-semibold text-lg">
                            View Transparency Reports
                        </button>
                    </div>
                </div>
                
                <!-- Scroll Indicator -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                    <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <main class="py-20 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-6">Transparent Governance at Your Fingertips</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Our comprehensive system ensures every peso is accounted for and every project is tracked from planning to completion.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1: Budget Analytics -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-blue to-blue-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Budget Analytics</h3>
                    <p class="text-gray-600">Detailed insights into budget allocation, spending patterns, and financial performance with interactive charts and reports.</p>
                </div>

                <!-- Feature 2: Public Transparency -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-secondary-green to-green-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Public Transparency</h3>
                    <p class="text-gray-600">Open access to budget information, expenditures, and project updates to ensure complete transparency in governance.</p>
                </div>

                <!-- Feature 3: Real-time Updates -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-accent-gold to-orange-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Real-time Updates</h3>
                    <p class="text-gray-600">Live tracking of projects, expenditures, and budget utilization with automated notifications and alerts.</p>
                </div>

                <!-- Feature 4: Audit Trail -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Audit Trail</h3>
                    <p class="text-gray-600">Complete audit trail of all financial transactions and decisions with user accountability and document management.</p>
                </div>

                <!-- Feature 5: Citizen Feedback -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Citizen Feedback</h3>
                    <p class="text-gray-600">Interactive platform for citizens to provide feedback, suggestions, and report concerns about budget utilization.</p>
                </div>

                <!-- Feature 6: Secure Access -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Secure Access</h3>
                    <p class="text-gray-600">Role-based access control ensuring data security while maintaining transparency and proper authorization levels.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Statistics Section -->
    <section class="py-20 bg-gradient-to-r from-primary-blue via-blue-600 to-secondary-green relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Our Impact in Numbers</h2>
                <p class="text-xl text-white/90">Building trust through transparency and accountability</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">₱2.5M</div>
                    <div class="text-xl opacity-90">Monthly Budget</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">45</div>
                    <div class="text-xl opacity-90">Active Projects</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="text-xl opacity-90">Transparency Rate</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                    <div class="text-4xl font-bold mb-2">1,200+</div>
                    <div class="text-xl opacity-90">Registered Citizens</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-8">Ready to Experience Transparent Governance?</h2>
            <p class="text-xl text-gray-600 mb-12 max-w-3xl mx-auto">Join thousands of citizens who are actively monitoring and participating in their local government's financial decisions.</p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <button class="bg-primary-blue hover:bg-blue-700 text-white px-10 py-4 rounded-xl transition-all duration-300 font-semibold text-lg shadow-xl hover:shadow-2xl transform hover:scale-105">
                    Explore Budget Data
                </button>
                <button class="border-2 border-secondary-green text-secondary-green px-10 py-4 rounded-xl hover:bg-secondary-green hover:text-white transition-all duration-300 font-semibold text-lg">
                    Download Reports
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-accent-gold rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 8h6m-6 4h6m0 4h6"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">Barangay eBudget</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Promoting transparency and accountability in local government financial management through innovative technology solutions.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-6">Quick Links</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Budget Reports</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Project Updates</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Public Announcements</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-6">Contact Information</h4>
                    <div class="space-y-3 text-gray-400">
                        <p class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Barangay Hall, Bacolod City</span>
                        </p>
                        <p class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>(034) 123-4567</span>
                        </p>
                        <p class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>ebudget@barangay.gov.ph</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Barangay eBudget Transparency System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Background slideshow functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }

        // Change slide every 4 seconds
        setInterval(nextSlide, 4000);

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

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        // Observe all feature cards
        document.querySelectorAll('.bg-white.rounded-2xl').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>