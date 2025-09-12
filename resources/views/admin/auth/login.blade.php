<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            padding: 20px 0;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
        }

        .login-container {
            position: relative;
            z-index: 1;
        }

        .login-box {
            background: rgba(42, 67, 101, 0.95);
            backdrop-filter: blur(20px);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #ffffff;
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .login-subtitle {
            text-align: center;
            margin-bottom: 40px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 1px;
        }

        .input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: 500;
            text-align: left;
        }

        .input-group input {
            width: 100%;
            padding: 18px 20px 18px 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .input-group select {
            width: 100%;
            padding: 18px 20px 18px 50px;
            padding-right: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            appearance: none;
            cursor: pointer;
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
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            pointer-events: none;
            font-size: 12px;
            z-index: 1;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 18px;
            z-index: 1;
        }

        .password-requirements {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }

        .password-requirements h4 {
            margin-bottom: 8px;
            color: #ffffff;
            font-size: 13px;
        }

        .password-requirements ul {
            list-style: none;
            padding-left: 0;
        }

        .password-requirements li {
            margin-bottom: 3px;
            padding-left: 15px;
            position: relative;
        }

        .password-requirements li:before {
            content: "•";
            color: rgba(255, 255, 255, 0.6);
            position: absolute;
            left: 0;
        }

        .login-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #ffffff;
        }

        .error-message {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.3);
            color: #ff6b6b;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            backdrop-filter: blur(5px);
        }

        .success-message {
            background: rgba(46, 204, 113, 0.2);
            border: 1px solid rgba(46, 204, 113, 0.3);
            color: #2ecc71;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            backdrop-filter: blur(5px);
        }

        .register-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #ffffff;
        }

        /* Icons using CSS */
        .user-icon::before {
            content: "👤";
        }

        .lock-icon::before {
            content: "🔒";
        }

        .barangay-icon::before {
            content: "🏢";
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .login-box {
                width: 90%;
                padding: 40px 30px;
            }
            
            .login-box h2 {
                font-size: 24px;
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
                    <label class="label">Barangay Role</label>
                    <div class="select-wrapper">
                        <div class="input-icon barangay-icon"></div>
                        <select name="barangay_role" required>
                            <option value="">Select Your Barangay Role</option>
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
                    <a href="#">Lost Password?</a>
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