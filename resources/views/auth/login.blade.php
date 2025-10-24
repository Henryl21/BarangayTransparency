<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Madridejos Barangay System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            padding: 20px;
            animation: backgroundShift 10s ease-in-out infinite alternate;
        }

        @keyframes backgroundShift {
            0% {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            100% {
                background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            }
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.4) 0%, transparent 60%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 60%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.3) 0%, transparent 60%);
            animation: floatingBubbles 15s ease-in-out infinite;
        }

        @keyframes floatingBubbles {
            0%, 100% {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
            50% {
                transform: translateY(-20px) scale(1.05);
                opacity: 0.8;
            }
        }

        body::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: sparkle 20s linear infinite;
        }

        @keyframes sparkle {
            0% { transform: rotate(0deg) translateX(0); }
            100% { transform: rotate(360deg) translateX(10px); }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            animation: slideInUp 0.8s ease-out;
        }

        @keyframes slideInUp {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-box {
            background: rgba(42, 67, 101, 0.95);
            backdrop-filter: blur(20px);
            padding: clamp(30px, 5vw, 50px) clamp(25px, 5vw, 40px);
            border-radius: clamp(15px, 3vw, 20px);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            animation: boxGlow 3s ease-in-out infinite alternate;
        }

        @keyframes boxGlow {
            0% {
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.3),
                    0 0 0 1px rgba(255, 255, 255, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1),
                    0 0 30px rgba(102, 126, 234, 0.1);
            }
            100% {
                box-shadow: 
                    0 25px 50px rgba(0, 0, 0, 0.4),
                    0 0 0 1px rgba(255, 255, 255, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2),
                    0 0 50px rgba(118, 75, 162, 0.2);
            }
        }

        .login-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            50% { left: -100%; }
            100% { left: 100%; }
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #ffffff;
            font-size: clamp(22px, 4vw, 28px);
            font-weight: 300;
            letter-spacing: clamp(1px, 0.5vw, 2px);
            text-transform: uppercase;
            animation: titleGlow 2s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% {
                text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            }
            100% {
                text-shadow: 0 0 20px rgba(102, 126, 234, 0.8), 0 0 30px rgba(118, 75, 162, 0.5);
            }
        }

        .login-subtitle {
            text-align: center;
            margin-bottom: clamp(25px, 5vw, 40px);
            color: rgba(255, 255, 255, 0.8);
            font-size: clamp(12px, 2.5vw, 14px);
            font-weight: 400;
            letter-spacing: 1px;
            animation: fadeInDelay 0.8s ease-out 0.3s both;
        }

        @keyframes fadeInDelay {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-group {
            position: relative;
            margin-bottom: clamp(20px, 4vw, 30px);
            animation: slideInLeft 0.6s ease-out;
            animation-fill-mode: both;
        }

        .input-group:nth-child(1) { animation-delay: 0.4s; }
        .input-group:nth-child(2) { animation-delay: 0.5s; }
        .input-group:nth-child(3) { animation-delay: 0.6s; }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: clamp(12px, 2.5vw, 14px);
            margin-bottom: 8px;
            font-weight: 500;
            text-align: left;
            transition: all 0.3s ease;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: clamp(14px, 3vw, 18px) clamp(16px, 4vw, 20px) clamp(14px, 3vw, 18px) clamp(40px, 8vw, 50px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: clamp(8px, 2vw, 12px);
            color: #ffffff;
            font-size: clamp(14px, 3vw, 16px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(5px);
            position: relative;
        }

        .input-group select {
            appearance: none;
            cursor: pointer;
            padding-right: clamp(40px, 8vw, 50px);
        }

        .input-group select option {
            background: #2a4365;
            color: white;
            padding: 10px;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: "▼";
            position: absolute;
            right: clamp(15px, 3vw, 20px);
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            pointer-events: none;
            font-size: clamp(10px, 2vw, 12px);
            z-index: 1;
            transition: all 0.3s ease;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 
                0 0 25px rgba(102, 126, 234, 0.3),
                0 0 50px rgba(255, 255, 255, 0.1),
                inset 0 0 20px rgba(255, 255, 255, 0.1);
            transform: translateY(-2px) scale(1.02);
        }

        .input-group input:focus::placeholder {
            color: rgba(255, 255, 255, 0.8);
            transform: translateX(5px);
        }

        .select-wrapper:focus-within::after {
            color: rgba(255, 255, 255, 0.9);
            transform: translateY(-50%) rotate(180deg);
        }

        .input-icon {
            position: absolute;
            left: clamp(12px, 3vw, 18px);
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: clamp(16px, 3.5vw, 18px);
            z-index: 1;
            transition: all 0.3s ease;
        }

        .input-group:focus-within .input-icon {
            color: rgba(255, 255, 255, 0.9);
            transform: translateY(-50%) scale(1.2);
            animation: iconPulse 0.6s ease-in-out;
        }

        @keyframes iconPulse {
            0%, 100% { transform: translateY(-50%) scale(1.2); }
            50% { transform: translateY(-50%) scale(1.4); }
        }

        .login-btn {
            width: 100%;
            padding: clamp(14px, 3vw, 18px);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: clamp(8px, 2vw, 12px);
            font-size: clamp(14px, 3vw, 16px);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: clamp(0.5px, 0.2vw, 1px);
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.6s ease-out 0.7s both;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.4s ease;
        }

        .login-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 15px 35px rgba(102, 126, 234, 0.4),
                0 0 30px rgba(118, 75, 162, 0.3);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:active {
            transform: translateY(-1px) scale(0.98);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
            animation: fadeInDelay 0.6s ease-out 0.8s both;
        }

        .forgot-password a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: clamp(12px, 2.5vw, 14px);
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-password a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .forgot-password a:hover {
            color: #ffffff;
            transform: translateY(-1px);
        }

        .forgot-password a:hover::after {
            width: 100%;
        }

        .error-message,
        .success-message {
            padding: clamp(10px, 2.5vw, 16px);
            border-radius: 8px;
            font-size: clamp(12px, 2.5vw, 14px);
            margin-bottom: 20px;
            backdrop-filter: blur(5px);
            word-wrap: break-word;
            animation: messageSlide 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }

        @keyframes messageSlide {
            0% {
                opacity: 0;
                transform: translateY(-20px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .error-message {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: #ff6b6b;
        }

        .success-message {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.3);
            color: #2ecc71;
        }

        .register-link {
            text-align: center;
            margin-top: clamp(20px, 4vw, 30px);
            padding-top: clamp(15px, 3vw, 20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            font-size: clamp(12px, 2.5vw, 14px);
            line-height: 1.5;
            animation: fadeInDelay 0.6s ease-out 0.9s both;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .register-link a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .register-link a:hover {
            color: #ffffff;
            text-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
        }

        .register-link a:hover::before {
            transform: translateX(100%);
        }

        /* Icons using CSS with animation */
        .user-icon::before {
            content: "👤";
        }

        .lock-icon::before {
            content: "🔒";
        }

        .barangay-icon::before {
            content: "🏢";
        }

        /* Floating particles */
        .login-container::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            right: -50px;
            bottom: -50px;
            background-image: 
                radial-gradient(2px 2px at 20px 30px, rgba(255,255,255,0.3), transparent),
                radial-gradient(2px 2px at 40px 70px, rgba(255,255,255,0.2), transparent),
                radial-gradient(1px 1px at 90px 40px, rgba(255,255,255,0.3), transparent),
                radial-gradient(1px 1px at 130px 80px, rgba(255,255,255,0.2), transparent);
            background-repeat: repeat;
            background-size: 150px 100px;
            animation: float 10s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }

        /* Enhanced mobile responsiveness */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            .login-box {
                margin: 0 auto;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
                min-height: 100vh;
            }
            
            .login-container {
                width: 100%;
            }
            
            .login-box {
                border-radius: 15px;
            }
            
            .input-group {
                margin-bottom: 20px;
            }
            
            .login-subtitle {
                line-height: 1.4;
            }
        }

        @media (max-width: 360px) {
            body {
                padding: 8px;
            }
            
            .login-box {
                border-radius: 12px;
            }
        }

        /* Landscape phone orientation */
        @media (max-height: 500px) and (orientation: landscape) {
            body {
                padding: 10px;
                align-items: flex-start;
            }
            
            .login-container {
                margin-top: 20px;
            }
            
            .login-box {
                padding: 25px 30px;
            }
            
            .login-subtitle {
                margin-bottom: 25px;
            }
            
            .input-group {
                margin-bottom: 20px;
            }
        }

        /* Very small screens */
        @media (max-width: 320px) {
            .login-box h2 {
                font-size: 20px;
                letter-spacing: 1px;
            }
            
            .login-subtitle {
                font-size: 11px;
            }
            
            .input-group input,
            .input-group select {
                padding-left: 35px;
                font-size: 14px;
            }
            
            .input-icon {
                left: 10px;
                font-size: 14px;
            }
        }

        /* Large screens optimization */
        @media (min-width: 1200px) {
            .login-container {
                max-width: 500px;
            }
        }

        /* Focus indicators for accessibility */
        @media (prefers-reduced-motion: no-preference) {
            .login-btn:focus {
                outline: 2px solid rgba(255, 255, 255, 0.5);
                outline-offset: 2px;
            }
        }

        /* Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            
            body::before,
            body::after,
            .login-box::before {
                animation: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            <div class="login-subtitle">Barangay Ebudget Transparency System</div>

            {{-- Show validation errors --}}
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Show session error (like wrong credentials) --}}
            @if (session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Show session success --}}
            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="input-group">
                    <div class="input-icon user-icon"></div>
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                </div>

                <div class="input-group">
                    <label class="label">Barangay </label>
                    <div class="select-wrapper">
                        <div class="input-icon barangay-icon"></div>
                        <select name="barangay_role" required>
                            <option value="">Select Your Barangay </option>
                            @foreach($barangays as $key => $name)
                                <option value="{{ $key }}" {{ old('barangay_role') == $key ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-icon lock-icon"></div>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="forgot-password">
                     <a href="{{ route('admin.forgot.password') }}">Lost Password?</a>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="register-link">
                Don't have an account?
                <a href="{{ route('admin.register') }}">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>