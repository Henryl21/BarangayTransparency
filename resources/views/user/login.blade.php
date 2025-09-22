<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Madridejos Barangay System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: linear-gradient(135deg, #2563eb, #1e40af); }
        .login-container { width: 100%; max-width: 400px; padding: 20px; }
        .login-box { background: #fff; border-radius: 16px; padding: 40px 30px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); text-align: center; animation: fadeIn 0.8s ease-in-out; }
        .login-box h2 { margin-bottom: 8px; font-size: 26px; font-weight: 700; color: #1e3a8a; }
        .login-subtitle { font-size: 14px; color: #64748b; margin-bottom: 25px; }
        .input-group { display: flex; align-items: center; background: #f1f5f9; margin-bottom: 18px; border-radius: 10px; padding: 10px 12px; }
        .input-group input, .input-group select { border: none; outline: none; flex: 1; background: transparent; font-size: 15px; color: #1e293b; }
        .input-icon { width: 20px; height: 20px; margin-right: 10px; background-size: cover; opacity: 0.6; }
        .user-icon { background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23674caf' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M12 14c-4 0-7 2-7 6v1h14v-1c0-4-3-6-7-6zM12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z'/%3E%3C/svg%3E"); }
        .lock-icon { background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23674caf' stroke-width='2' viewBox='0 0 24 24'%3E%3Crect x='5' y='11' width='14' height='10' rx='2'/%3E%3Cpath d='M9 11V7a3 3 0 0 1 6 0v4'/%3E%3C/svg%3E"); }
        .map-icon { background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23674caf' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 011.553-1.894L9 1m0 0l6 3m-6-3v19m6-16l5.447 2.724A2 2 0 0121 8.618v9.764a2 2 0 01-1.553 1.894L15 23m0-19v19'/%3E%3C/svg%3E"); }
        .forgot-password { text-align: right; margin-bottom: 15px; }
        .forgot-password a { font-size: 13px; text-decoration: none; color: #2563eb; transition: color 0.3s; }
        .forgot-password a:hover { color: #1e3a8a; }
        .login-btn { width: 100%; padding: 12px; background: #2563eb; color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .login-btn:hover { background: #1e3a8a; transform: translateY(-2px); box-shadow: 0 6px 14px rgba(0,0,0,0.2); }
        .register-link { margin-top: 20px; font-size: 14px; color: #475569; }
        .register-link a { color: #2563eb; text-decoration: none; font-weight: 600; transition: color 0.3s; }
        .register-link a:hover { color: #1e3a8a; }
        .error-message, .success-message { margin-bottom: 15px; padding: 10px; border-radius: 8px; font-size: 14px; text-align: left; }
        .error-message { background: #fee2e2; color: #b91c1c; }
        .success-message { background: #dcfce7; color: #15803d; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to   { opacity: 1; transform: translateY(0); } }
        @media (max-width: 500px) { .login-box { padding: 30px 20px; } }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>User Login</h2>
            <div class="login-subtitle">Barangay Ebudget Transparency System</div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Session Messages --}}
            @if (session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('user.login.attempt') }}">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <div class="input-icon user-icon"></div>
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                </div>

                <!-- Password -->
                <div class="input-group">
                    <div class="input-icon lock-icon"></div>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <!-- Barangay Selection -->
                <div class="input-group">
                    <div class="input-icon map-icon"></div>
                    <select name="barangay_role" required>
                        <option value="">-- Select Your Barangay --</option>
                        @foreach ($barangays as $key => $name)
                            <option value="{{ $key }}" {{ old('barangay_role') == $key ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="forgot-password">
                    <a href="#">Lost Password?</a>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="register-link">
                Don't have an account? 
                <a href="{{ route('user.register') }}">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>
