<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password | Madridejos Barangay System</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
    }

    /* Disable dark SweetAlert backdrop effect */
    .swal2-container {
      background: rgba(0, 0, 0, 0.1) !important;
      backdrop-filter: blur(3px);
    }

    body::before {
      content: "";
      position: absolute;
      width: 1000px;
      height: 1000px;
      background: radial-gradient(circle, #00b4d8 0%, transparent 70%);
      top: -400px;
      left: -400px;
      filter: blur(200px);
      opacity: 0.4;
      animation: glowMove 8s ease-in-out infinite alternate;
      z-index: 0;
    }

    @keyframes glowMove {
      0% { transform: translate(0, 0); }
      100% { transform: translate(100px, 80px); }
    }

    .card {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 50px 40px;
      width: 100%;
      max-width: 400px;
      color: #fff;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
      z-index: 1;
      position: relative;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .card h2 {
      font-size: 28px;
      margin-bottom: 20px;
      color: #fff;
      text-shadow: 0 0 10px rgba(255,255,255,0.3);
    }

    .input-group {
      position: relative;
      margin-top: 30px;
    }

    .input-group input {
      width: 100%;
      padding: 14px 15px;
      border: none;
      outline: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    .input-group label {
      position: absolute;
      left: 15px;
      top: 14px;
      color: rgba(255, 255, 255, 0.7);
      font-size: 15px;
      pointer-events: none;
      transition: 0.3s ease;
    }

    .input-group input:focus + label,
    .input-group input:not(:placeholder-shown) + label {
      top: -10px;
      left: 10px;
      font-size: 13px;
      color: #00b4d8;
      background: rgba(0,0,0,0.3);
      padding: 0 6px;
      border-radius: 4px;
    }

    .input-group input:focus {
      background: rgba(255, 255, 255, 0.25);
      box-shadow: 0 0 10px rgba(0,180,216,0.6);
      transform: scale(1.02);
    }

    button {
      margin-top: 35px;
      width: 100%;
      background: linear-gradient(135deg, #00b4d8, #0077b6);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 14px 0;
      font-size: 16px;
      letter-spacing: 1px;
      cursor: pointer;
      transition: 0.3s ease;
      box-shadow: 0 0 12px rgba(0,180,216,0.4);
    }

    button:hover {
      background: linear-gradient(135deg, #0096c7, #023e8a);
      box-shadow: 0 0 25px rgba(0,180,216,0.7);
      transform: translateY(-3px);
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #90e0ef;
      font-size: 14px;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .back-link:hover {
      color: #caf0f8;
    }

    @media (max-width: 480px) {
      .card {
        padding: 40px 25px;
      }
      .card h2 {
        font-size: 24px;
      }
    }
  </style>
</head>

<body>
  <div class="card">
    <h2>Forgot Password</h2>

    @if (session('success'))
      <script>
        window.addEventListener('load', () => {
          Swal.fire({
            icon: 'success',
            title: 'Email Sent!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#00b4d8',
            background: '#f0faff',
            color: '#023e8a'
          });
        });
      </script>
    @endif

    @if ($errors->any())
      <script>
        window.addEventListener('load', () => {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#d33',
            background: '#fff5f5',
            color: '#900'
          });
        });
      </script>
    @endif

    <form id="forgotForm" method="POST" action="{{ route('user.forgot.password.send') }}">
      @csrf
      <div class="input-group">
        <input type="email" name="email" id="email" required placeholder=" ">
        <label for="email">Email Address</label>
      </div>

      <button type="submit">Send Reset Link</button>
    </form>

    <a href="{{ route('user.login') }}" class="back-link">← Back to Login</a>
  </div>

  <script>
    // Loader effect (now non-blocking)
    const form = document.getElementById('forgotForm');
    form.addEventListener('submit', (e) => {
      // Add small delay and fade
      Swal.fire({
        title: 'Sending...',
        text: 'Please wait while we send your reset link.',
        allowOutsideClick: false,
        background: 'rgba(255,255,255,0.9)',
        color: '#023e8a',
        didOpen: () => Swal.showLoading(),
        showConfirmButton: false,
      });

      // Close loader gently after 1.5s (before Laravel reload)
      setTimeout(() => {
        Swal.close();
      }, 1500);
    });
  </script>
</body>
</html
