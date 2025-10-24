<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Account - Madridejos Barangay System</title>
  <style>
    /* --- Reset & Base --- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #2563eb, #1e40af);
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* --- Container --- */
    .verify-box {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
      animation: slideUp 0.6s ease-in-out;
    }

    @keyframes slideUp {
      from { transform: translateY(40px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    /* --- Typography --- */
    h2 {
      color: #1e3a8a;
      margin-bottom: 10px;
      font-size: 1.6rem;
    }

    p {
      color: #374151;
      margin-bottom: 20px;
      font-size: 0.95rem;
    }

    /* --- Form --- */
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    input:focus {
      border-color: #2563eb;
      outline: none;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
    }

    button {
      background: #2563eb;
      color: #ffffff;
      padding: 12px;
      border: none;
      border-radius: 8px;
      width: 100%;
      font-weight: 600;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    button:hover {
      background: #1e3a8a;
      transform: translateY(-1px);
    }

    /* --- Alerts --- */
    .error {
      background: #fee2e2;
      color: #b91c1c;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
      font-size: 0.9rem;
    }

    .success {
      background: #dcfce7;
      color: #15803d;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 10px;
      font-size: 0.9rem;
    }

    /* --- Resend Link --- */
    .resend {
      margin-top: 14px;
      font-size: 0.9rem;
      color: #374151;
    }

    .resend a {
      color: #2563eb;
      font-weight: 600;
      text-decoration: none;
    }

    .resend a:hover {
      text-decoration: underline;
    }

    /* --- Responsive --- */
    @media (max-width: 480px) {
      .verify-box {
        padding: 30px 20px;
      }
      h2 {
        font-size: 1.4rem;
      }
    }
  </style>
</head>
<body>
  <div class="verify-box">
    <h2>Email Verification</h2>
    <p>We sent a 6-digit verification code to your email: <strong>{{ $email }}</strong></p>

    {{-- Success / Error Messages --}}
    @if(session('error'))
      <div class="error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
      <div class="success">{{ session('success') }}</div>
    @endif

    {{-- Verification Form --}}
    <form method="POST" action="{{ route('user.verify.otp') }}">
      @csrf
      <input type="hidden" name="email" value="{{ $email }}">
      <input type="text" 
             name="otp_code" 
             placeholder="Enter 6-digit code" 
             maxlength="6" 
             pattern="\d{6}" 
             inputmode="numeric" 
             required>
      <button type="submit">Verify</button>
    </form>

    {{-- Optional Resend Link (only if you have route) --}}
    <div class="resend">
      Didn’t receive the code? 
      <a href="{{ route('user.resend.otp', ['email' => $email]) }}">Resend Code</a>
    </div>
  </div>
</body>
</html>
