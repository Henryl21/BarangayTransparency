<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Login - Madridejos Barangay System</title>
<style>
    * {
        margin: 0; padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        overflow: hidden;
        background: linear-gradient(120deg, #1e3a8a, #2563eb, #38bdf8);
        animation: bgGradient 10s ease infinite alternate;
    }

    @keyframes bgGradient {
        0% { background-position: left; }
        100% { background-position: right; }
    }

    .background-slideshow {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: -2;
        overflow: hidden;
        filter: brightness(1.3);
    }

    .background-slideshow img {
        position: absolute;
        width: 100%; height: 100%;
        object-fit: cover;
        opacity: 0;
        animation: fadeSlideshow 20s infinite ease-in-out;
        transform: scale(1);
    }

    .background-slideshow img:nth-child(1) { animation-delay: 0s; }
    .background-slideshow img:nth-child(2) { animation-delay: 5s; }
    .background-slideshow img:nth-child(3) { animation-delay: 10s; }
    .background-slideshow img:nth-child(4) { animation-delay: 15s; }

    @keyframes fadeSlideshow {
        0% { opacity: 0; transform: scale(1.1); }
        10% { opacity: 1; transform: scale(1); }
        40% { opacity: 1; transform: scale(1.02); }
        50% { opacity: 0; transform: scale(1.1); }
        100% { opacity: 0; transform: scale(1.1); }
    }

    .overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: radial-gradient(circle at center, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
        animation: pulseGlow 8s infinite alternate;
        z-index: -1;
    }

    @keyframes pulseGlow {
        0% { background: rgba(0,0,0,0.4); }
        100% { background: rgba(0,0,0,0.6); }
    }

    .login-container {
        width: 100%;
        max-width: 420px;
        padding: 20px;
        position: relative;
        z-index: 1;
        perspective: 1000px;
    }

    .login-box {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 20px;
        padding: 45px 35px;
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3),
                    0 0 15px rgba(37,99,235,0.4),
                    inset 0 0 10px rgba(255,255,255,0.1);
        text-align: center;
        color: white;
        transform-style: preserve-3d;
        animation: boxEnter 1s ease forwards, floaty 5s ease-in-out infinite alternate;
    }

    @keyframes boxEnter {
        0% { transform: rotateY(30deg) translateY(60px); opacity: 0; }
        100% { transform: rotateY(0deg) translateY(0); opacity: 1; }
    }

    @keyframes floaty {
        0% { transform: translateY(0) rotateY(0deg); }
        100% { transform: translateY(-10px) rotateY(2deg); }
    }

    .login-box h2 {
        margin-bottom: 10px;
        font-size: 28px;
        font-weight: 800;
        color: #ffffff;
        text-shadow: 0 0 10px rgba(59,130,246,0.8);
        letter-spacing: 1px;
    }

    .login-subtitle {
        font-size: 14px;
        color: #dbeafe;
        margin-bottom: 25px;
        text-shadow: 0 0 6px rgba(255, 255, 255, 0.95);
    }

    .input-group {
        display: flex;
        align-items: center;
        background: rgba(30,41,59,0.4);
        margin-bottom: 18px;
        border-radius: 12px;
        padding: 10px 12px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255,255,255,0.25);
    }

    .input-group:hover {
        box-shadow: 0 0 12px rgba(59,130,246,0.7);
        transform: scale(1.02);
    }

    .input-group input, .input-group select {
        border: none; outline: none;
        flex: 1; background: transparent;
        font-size: 15px; color: #ffffff;
    }

    ::placeholder {
        color: #ffffff;
        opacity: 1;
        text-shadow: 0 0 6px rgba(96,165,250,0.8);
    }

    .input-icon {
        width: 20px; height: 20px; margin-right: 10px;
        background-size: cover; opacity: 0.8;
        filter: drop-shadow(0 0 3px rgba(41, 37, 37, 0.96));
    }

    label {
        display: block;
        text-align: left;
        font-size: 14px;
        color: #e0f2fe;
        margin-bottom: 6px;
        text-shadow: 0 0 6px rgba(37,99,235,0.8);
        font-weight: 600;
    }

    label[for="barangay"] {
        display: block;
        text-align: center;
        width: 100%;
        border: 1px solid rgba(255, 255, 255, 0);
        margin-bottom: 6px;
        color: #e0f2fe;
        text-shadow: 0 0 6px rgba(37,99,235,0.8);
        font-weight: 600;
    }

    .input-group select:hover,
    .input-group select:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 8px rgba(96,165,250,0.6);
        outline: none;
    }

    .input-group select option {
        background-color: #1e293b;
        color: #ffffff;
    }

    .input-group select option:checked,
    .input-group select option:hover {
        background-color: #2563eb;
        color: #ffffff;
    }

    .user-icon {
        background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23ffffff' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M12 14c-4 0-7 2-7 6v1h14v-1c0-4-3-6-7-6zM12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5z'/%3E%3C/svg%3E");
    }
    .lock-icon {
        background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23ffffff' stroke-width='2' viewBox='0 0 24 24'%3E%3Crect x='5' y='11' width='14' height='10' rx='2'/%3E%3Cpath d='M9 11V7a3 3 0 0 1 6 0v4'/%3E%3C/svg%3E");
    }
    .map-icon {
        background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%23ffffff' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 011.553-1.894L9 1m0 0l6 3m-6-3v19m6-16l5.447 2.724A2 2 0 0121 8.618v9.764a2 2 0 01-1.553 1.894L15 23m0-19v19'/%3E%3C/svg%3E");
    }

    .toggle-password {
        width: 24px; height: 24px;
        margin-left: 8px;
        cursor: pointer;
        display: none;
        flex-shrink: 0;
        transition: opacity 0.3s ease;
    }

    .toggle-password:hover { opacity: 1 !important; }

    .toggle-password svg {
        width: 100%;
        height: 100%;
        stroke: #ffffff;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
        filter: drop-shadow(0 0 3px rgba(96, 165, 250, 0.8));
    }

    .forgot-password {
        text-align: right;
        margin-bottom: 15px;
    }

    .forgot-password a {
        font-size: 13px;
        text-decoration: none;
        color: #93c5fd;
        transition: color 0.3s, text-shadow 0.3s;
    }

    .forgot-password a:hover {
        color: #fff;
        text-shadow: 0 0 6px #60a5fa;
    }

    .login-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #2563eb, #1e3a8a);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 0 12px rgba(59,130,246,0.6);
    }

    .login-btn:hover {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 0 18px rgba(96,165,250,0.8);
    }

    .register-link {
        margin-top: 20px;
        font-size: 14px;
        color: #dbeafe;
    }

    .register-link a {
        color: #60a5fa;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s, text-shadow 0.3s;
    }

    .register-link a:hover {
        color: #fff;
        text-shadow: 0 0 6px #60a5fa;
    }

    .error-message, .success-message {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
        text-align: left;
        animation: fadeInMessage 0.6s ease;
    }

    @keyframes fadeInMessage {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .error-message {
        background: rgba(239,68,68,0.2);
        color: #fecaca;
        border-left: 4px solid #ef4444;
    }

    .success-message {
        background: rgba(34,197,94,0.2);
        color: #bbf7d0;
        border-left: 4px solid #22c55e;
    }

    #barangayPreviewContainer {
        display: none;
        margin-top: 15px;
        text-align: center;
        animation: fadeIn 0.6s ease;
    }

    #barangayPreviewContainer img {
        width: 100%;
        max-width: 320px;
        height: 200px;
        object-fit: cover;
        border-radius: 15px;
        border: 2px solid rgba(255,255,255,0.25);
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    /* -------------------- RESPONSIVE SECTION -------------------- */
    @media (max-width: 768px) {
        body {
            padding: 15px;
            overflow-y: auto;
        }

        .login-container {
            max-width: 95%;
            padding: 10px;
        }

        .login-box {
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.35);
        }

        .login-box h2 {
            font-size: 24px;
        }

        .login-subtitle {
            font-size: 13px;
        }

        .input-group {
            padding: 8px 10px;
        }

        .login-btn {
            padding: 10px;
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .login-box {
            padding: 25px 18px;
        }

        .login-box h2 {
            font-size: 22px;
        }

        .input-group input, .input-group select {
            font-size: 14px;
        }

        label {
            font-size: 13px;
        }

        .forgot-password a {
            font-size: 12px;
        }

        .register-link {
            font-size: 13px;
        }

        #barangayPreviewContainer img {
            max-width: 100%;
            height: 160px;
        }
    }
</style>
</head>

<body>
<!-- Background Slideshow -->
<div class="background-slideshow">
    <img src="/storage/images/malbago.jpg">
    <img src="/storage/images/poblacion.jpg">
    <img src="/storage/images/tabagak.jpg">
    <img src="/storage/images/bunakan.jpg">
    <img src="/storage/images/kodia.jpg">
    <img src="/storage/images/tugas.jpg">
    <img src="/storage/images/san-agustin.jpg">
    <img src="/storage/images/tarong.jpg">
    <img src="/storage/images/pili.jpg">
    <img src="/storage/images/mancilang.jpg">
    <img src="/storage/images/kaongkod.jpg">
    <img src="/storage/images/talangnan.jpg">
</div>

<div class="overlay"></div>

<!-- Login Form -->
<div class="login-container">
    <div class="login-box">
        <h2>User Login</h2>
        <div class="login-subtitle">Barangay eBudget Transparency System</div>

        <!-- Laravel Flash Messages -->
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('user.login.attempt') }}">
            @csrf
            <label for="email">Email Address</label>
            <div class="input-group">
                <div class="input-icon user-icon"></div>
                <input type="email" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}" required>
            </div>

            <label for="password">Password</label>
            <div class="input-group">
                <div class="input-icon lock-icon"></div>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" id="togglePassword">
                    <svg id="eyeOpen" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg id="eyeClosed" viewBox="0 0 24 24" style="display: none;">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </span>
            </div>

            <label for="barangay_role">Barangay</label>
            <div class="input-group">
                <div class="input-icon map-icon"></div>
                <select name="barangay_role" id="barangay_role" required>
                    <option value="">-- Select Your Barangay --</option>
                    @foreach ($barangays as $key => $name)
                        <option value="{{ $key }}" {{ old('barangay_role') == $key ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
@if ($errors->has('email') && str_contains($errors->first('email'), 'Please try again in'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const message = {!! json_encode($errors->first('email')) !!};
            const match = message.match(/(\d+)\s*second/);

            if (match) {
                let remaining = parseInt(match[1]);

                Swal.fire({
                    title: "Too Many Login Attempts",
                    html: `Please try again in <b>${remaining}</b> second(s).`,
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    backdrop: `rgba(0, 0, 0, 0.7)`,
                    didOpen: () => {
                        const b = Swal.getHtmlContainer().querySelector("b");
                        const interval = setInterval(() => {
                            remaining--;
                            b.textContent = remaining;

                            if (remaining <= 0) {
                                clearInterval(interval);
                                Swal.update({
                                    title: "You Can Try Again",
                                    html: "The lockout period has ended. You can now log in.",
                                    icon: "success",
                                    showConfirmButton: false
                                });

                                setTimeout(() => {
                                    Swal.close();
                                    location.reload();
                                }, 1500);
                            }
                        }, 1000);
                    }
                });
            }
        });
    </script>
@endif


            <!-- Image Preview -->
            <div id="barangayPreviewContainer">
                <img id="barangayImagePreview" src="" alt="Barangay Preview">
            </div>

            <div class="forgot-password">
                <a href="{{ route('user.forgot.password') }}">Lost Password?</a>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <div class="register-link">
            Don't have an account?
            <a href="{{ route('user.register') }}">Register here</a>
        </div>
    </div>
</div>

<script>
const passwordField = document.getElementById("password");
const toggleBtn = document.getElementById("togglePassword");
const eyeOpen = document.getElementById("eyeOpen");
const eyeClosed = document.getElementById("eyeClosed");

passwordField.addEventListener("input", () => {
    if (passwordField.value.length > 0) toggleBtn.style.display = "block";
    else {
        toggleBtn.style.display = "none";
        passwordField.type = "password";
        eyeOpen.style.display = "block";
        eyeClosed.style.display = "none";
    }
});

toggleBtn.addEventListener("click", () => {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeOpen.style.display = "none";
        eyeClosed.style.display = "block";
    } else {
        passwordField.type = "password";
        eyeOpen.style.display = "block";
        eyeClosed.style.display = "none";
    }
});

const barangaySelect = document.getElementById("barangay_role");
const barangayPreviewContainer = document.getElementById("barangayPreviewContainer");
const barangayImage = document.getElementById("barangayImagePreview");

const barangayImages = {
    "malbago": "/storage/images/malbago.jpg",
    "poblacion": "/storage/images/poblacion.jpg",
    "tabagak": "/storage/images/tabagak.jpg",
    "bunakan": "/storage/images/bunakan.jpg",
    "kodia": "/storage/images/kodia.jpg",
    "tugas": "/storage/images/tugas.jpg",
    "san-agustin": "/storage/images/san-agustin.jpg",
    "tarong": "/storage/images/tarong.jpg",
    "pili": "/storage/images/pili.jpg",
    "mancilang": "/storage/images/mancilang.jpg",
    "kaongkod": "/storage/images/kaongkod.jpg",
    "talangnan": "/storage/images/talangnan.jpg"
};

barangaySelect.addEventListener("change", () => {
    const selected = barangaySelect.value.toLowerCase();
    if (barangayImages[selected]) {
        barangayImage.src = barangayImages[selected];
        barangayPreviewContainer.style.display = "block";
    } else {
        barangayPreviewContainer.style.display = "none";
        barangayImage.src = "";
    }
});
</script>

</body>
</html>
