<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register - Madridejos Barangay System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: linear-gradient(135deg, #2563eb, #1e40af); }
        .register-container { width: 100%; max-width: 450px; padding: 20px; }
        .register-box { background: #fff; border-radius: 16px; padding: 40px 30px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); text-align: center; animation: fadeIn 0.8s ease-in-out; }
        .register-box h2 { margin-bottom: 8px; font-size: 26px; font-weight: 700; color: #1e3a8a; }
        .register-subtitle { font-size: 14px; color: #64748b; margin-bottom: 25px; }
        .input-group { display: flex; align-items: center; background: #f1f5f9; margin-bottom: 18px; border-radius: 10px; padding: 10px 12px; }
        .input-group input, .input-group select { border: none; outline: none; flex: 1; background: transparent; font-size: 15px; color: #1e293b; }
        .input-icon { width: 20px; height: 20px; margin-right: 10px; background-size: cover; opacity: 0.6; }
        .user-icon { background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23674caf' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M12 14c-4 0-7 2-7 6v1h14v-1c0-4-3-6-7-6zM12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z'/%3E%3C/svg%3E"); }
        .email-icon { background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23674caf' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M4 4h16v16H4z'/%3E%3Cpath d='M22 6l-10 7L2 6'/%3E%3C/svg%3E"); }
        .lock-icon { background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23674caf' stroke-width='2' viewBox='0 0 24 24'%3E%3Crect x='5' y='11' width='14' height='10' rx='2'/%3E%3Cpath d='M9 11V7a3 3 0 0 1 6 0v4'/%3E%3C/svg%3E"); }
        .register-btn { width: 100%; padding: 12px; background: #2563eb; color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        .register-btn:hover { background: #1e3a8a; transform: translateY(-2px); box-shadow: 0 6px 14px rgba(0,0,0,0.2); }
        .login-link { margin-top: 20px; font-size: 14px; color: #475569; }
        .login-link a { color: #2563eb; text-decoration: none; font-weight: 600; transition: color 0.3s; }
        .login-link a:hover { color: #1e3a8a; }
        .error-message, .success-message { margin-bottom: 15px; padding: 10px; border-radius: 8px; font-size: 14px; text-align: left; }
        .error-message { background: #fee2e2; color: #b91c1c; }
        .success-message { background: #dcfce7; color: #15803d; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 500px) { .register-box { padding: 30px 20px; } }
        .profile-preview { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #2563eb; margin: 0 auto 15px; display: block; }
        #password-strength { text-align: left; font-size: 12px; margin-bottom: 10px; }
        #password-strength ul { list-style: none; padding-left: 0; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <h2>User Registration</h2>
            <div class="register-subtitle">Barangay Ebudget Transparency System</div>

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

            <form method="POST" action="{{ route('user.register.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Profile Preview -->
                <img id="preview-image" src="https://ui-avatars.com/api/?name=User" class="profile-preview" alt="Preview">

                <!-- Full Name -->
                <div class="input-group">
                    <div class="input-icon user-icon"></div>
                    <input type="text" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}" required>
                </div>

                <!-- Contact Number -->
                <div class="input-group">
                    <div class="input-icon user-icon"></div>
                    <input type="text" name="number" placeholder="Contact Number" value="{{ old('number') }}" required>
                </div>

                <!-- Age -->
                <div class="input-group">
                    <div class="input-icon user-icon"></div>
                    <input type="number" name="age" placeholder="Age" value="{{ old('age') }}" required>
                </div>

                <!-- Birthdate -->
                <div class="input-group">
                    <div class="input-icon user-icon"></div>
                    <input type="date" name="birthdate" value="{{ old('birthdate') }}" required>
                </div>

                <!-- Barangay Selection -->
                <div class="input-group">
                    <div class="input-icon user-icon"></div>
                    <select name="barangay_role" required>
                        <option value="">-- Select Barangay --</option>
                        @foreach (\App\Models\User::getBarangays() as $key => $name)
                            <option value="{{ $key }}" {{ old('barangay_role') == $key ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Profile Photo -->
                <div class="input-group">
                    <div class="input-icon user-icon"></div>
                    <input type="file" name="profile_photo" accept="image/*" onchange="previewFile(event)">
                </div>

                <!-- Email -->
                <div class="input-group">
                    <div class="input-icon email-icon"></div>
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                </div>

                <!-- Password -->
                <div class="input-group">
                    <div class="input-icon lock-icon"></div>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>

                <!-- Password Strength -->
                <div id="password-strength">
                    <div>Password must contain:</div>
                    <ul>
                        <li id="length" style="color:red;">• At least 8 characters</li>
                        <li id="uppercase" style="color:red;">• Uppercase letter</li>
                        <li id="lowercase" style="color:red;">• Lowercase letter</li>
                        <li id="number" style="color:red;">• Number</li>
                        <li id="symbol" style="color:red;">• Special character (@$!%*?&)</li>
                    </ul>
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <div class="input-icon lock-icon"></div>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <button type="submit" class="register-btn">Register</button>
            </form>

            <div class="login-link">
                Already have an account? 
                <a href="{{ route('user.login') }}">Login here</a>
            </div>
        </div>
    </div>

    <script>
        // Preview uploaded profile photo
        function previewFile(event) {
            const input = event.target;
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const lengthCheck = document.getElementById('length');
        const uppercaseCheck = document.getElementById('uppercase');
        const lowercaseCheck = document.getElementById('lowercase');
        const numberCheck = document.getElementById('number');
        const symbolCheck = document.getElementById('symbol');

        passwordInput.addEventListener('input', () => {
            const value = passwordInput.value;

            lengthCheck.style.color = value.length >= 8 ? 'green' : 'red';
            uppercaseCheck.style.color = /[A-Z]/.test(value) ? 'green' : 'red';
            lowercaseCheck.style.color = /[a-z]/.test(value) ? 'green' : 'red';
            numberCheck.style.color = /[0-9]/.test(value) ? 'green' : 'red';
            symbolCheck.style.color = /[@$!%*?&]/.test(value) ? 'green' : 'red';
        });
    </script>
</body>
</html>
