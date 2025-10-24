<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Admin Portal</title>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top, #0f172a, #1e293b 60%, #334155);
            overflow: hidden;
        }

        /* Floating particles background */
        body::before, body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
            z-index: 0;
        }

        body::before {
            width: 400px;
            height: 400px;
            background: #3b82f6;
            top: -100px;
            left: -100px;
        }

        body::after {
            width: 500px;
            height: 500px;
            background: #06b6d4;
            bottom: -150px;
            right: -150px;
        }

        .container {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
            width: 400px;
            padding: 45px 40px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .container h2 {
            color: #f1f5f9;
            margin-bottom: 25px;
            font-size: 1.9rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.4);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input[type="email"] {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            outline: none;
            color: #f8fafc;
            padding: 14px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        input[type="email"]:focus {
            border-color: #38bdf8;
            background: rgba(255, 255, 255, 0.18);
            transform: scale(1.02);
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.4);
        }

        input[type="email"]::placeholder {
            color: rgba(255, 255, 255, 0.65);
        }

        button {
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .submit-btn {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            color: white;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 25px rgba(6, 182, 212, 0.6);
        }

        .back-btn {
            background: transparent;
            border: 2px solid #94a3b8;
            color: #cbd5e1;
            margin-top: 10px;
        }

        .back-btn:hover {
            background: rgba(148, 163, 184, 0.15);
            color: #38bdf8;
            border-color: #38bdf8;
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.3);
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form method="POST" action="{{ route('admin.forgot.password.send') }}">
            @csrf
            <input type="email" name="email" placeholder="Enter your registered email" required>
            <button type="submit" class="submit-btn">Send Reset Link</button>
        </form>

        <!-- Back Button -->
        <button class="back-btn" onclick="window.location.href='{{ route('admin.login') }}'">← Back to Login</button>
    </div>

    <!-- SweetAlert Notifications -->
    @if (session('success'))
        <script>
            Swal.fire({
                title: '✅ Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                background: '#1e293b',
                color: '#fff',
                confirmButtonColor: '#3b82f6',
                backdrop: `rgba(0, 0, 0, 0.85)`
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                title: '⚠️ Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                icon: 'error',
                background: '#1e293b',
                color: '#fff',
                confirmButtonColor: '#ef4444',
                backdrop: `rgba(0, 0, 0, 0.85)`
            });
        </script>
    @endif
</body>
</html>
