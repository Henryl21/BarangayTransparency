<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Register - Madridejos Barangay System</title>
  <style>
    * {
      margin: 0; padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      min-height: 100vh;
      overflow-y: auto;
      overflow-x: hidden;
      position: relative;
      background: #000;
      color: #fff;
    }

    /* === Background Slideshow === */
    .background-slideshow {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      overflow: hidden;
      z-index: -3;
    }

    .background-slideshow img {
      position: absolute;
      width: 100%; height: 100%;
      object-fit: cover;
      opacity: 0;
      animation: slideShow 72s infinite;
      transition: opacity 1s ease-in-out;
    }

    /* Delay each image for smooth fade transitions */
    .background-slideshow img:nth-child(1) { animation-delay: 0s; }
    .background-slideshow img:nth-child(2) { animation-delay: 6s; }
    .background-slideshow img:nth-child(3) { animation-delay: 12s; }
    .background-slideshow img:nth-child(4) { animation-delay: 18s; }
    .background-slideshow img:nth-child(5) { animation-delay: 24s; }
    .background-slideshow img:nth-child(6) { animation-delay: 30s; }
    .background-slideshow img:nth-child(7) { animation-delay: 36s; }
    .background-slideshow img:nth-child(8) { animation-delay: 42s; }
    .background-slideshow img:nth-child(9) { animation-delay: 48s; }
    .background-slideshow img:nth-child(10){ animation-delay: 54s; }
    .background-slideshow img:nth-child(11){ animation-delay: 60s; }
    .background-slideshow img:nth-child(12){ animation-delay: 66s; }

    @keyframes slideShow {
      0% { opacity: 0; transform: scale(1); }
      5% { opacity: 1; transform: scale(1.02); }
      25% { opacity: 1; transform: scale(1.04); }
      30% { opacity: 0; transform: scale(1.06); }
      100% { opacity: 0; }
    }

    /* === Overlay === */
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.45);
      z-index: -2;
      backdrop-filter: blur(6px);
    }

    /* === Register Container === */
    .register-container {
      width: 100%;
      max-width: 480px;
      padding: 25px;
      margin: 40px 0;
      z-index: 1;
    }

    /* === Register Box (Glass Effect + Shadow) === */
    .register-box {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 18px;
      padding: 40px 30px;
      backdrop-filter: blur(15px);
      border: 2px solid rgba(255, 255, 255, 0.35);
      text-align: center;
      animation: floatIn 1s ease forwards;
      transform: translateY(20px);
      box-shadow:
        0 0 20px rgba(255, 255, 255, 0.2),
        0 8px 32px rgba(0, 0, 0, 0.4);
    }

    @keyframes floatIn { to { transform: translateY(0); opacity: 1; } }

    .register-box h2 {
      margin-bottom: 10px;
      font-size: 26px;
      font-weight: 700;
      color: #fff;
      text-shadow: 0 0 10px rgba(255,255,255,0.5);
    }

    .register-subtitle {
      font-size: 14px;
      color: #d1d5db;
      margin-bottom: 25px;
    }

    /* === Input Fields === */
    .input-group {
      position: relative;
      display: flex;
      align-items: center;
      background: hsla(0, 38%, 91%, 0.84);
      margin-bottom: 18px;
      border-radius: 12px;
      padding: 10px 14px;
      transition: all 0.3s ease;
      border: 1.5px solid rgba(0, 0, 0, 0.15);
      box-shadow: 0 2px 8px rgba(126, 213, 181, 0.42);
    }

    .input-group:hover {
      border-color: rgba(237, 226, 226, 0.87);
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    }

    .input-group input,
    .input-group select {
      border: none;
      outline: none;
      flex: 1;
      background: transparent;
      font-size: 15px;
      color: #2f2c2c;
    }

    .input-group input::placeholder { color: #1c1717; }

    .input-icon {
      width: 22px; height: 22px;
      margin-right: 10px;
      background-size: cover;
      opacity: 0.9;
      filter: brightness(2);
    }

    .toggle-password {
      cursor: pointer;
      position: absolute;
      right: 12px;
      font-size: 18px;
      color: #fff;
      opacity: 0.8;
      transition: opacity 0.3s;
    }
    .toggle-password:hover { opacity: 1; }

    /* === Button === */
    .register-btn {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #2563eb, #1e3a8a);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 0 10px rgba(37,99,235,0.5);
    }
    .register-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 20px rgba(37,99,235,0.8);
    }

    .login-link { margin-top: 20px; font-size: 14px; color: rgba(255,255,255,0.8); }
    .login-link a {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      text-shadow: 0 0 6px rgba(255,255,255,0.5);
    }
    .login-link a:hover { color: #a5b4fc; }

    .profile-preview {
      width: 100px; height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid rgba(255,255,255,0.6);
      margin: 0 auto 15px;
      display: block;
      box-shadow: 0 0 10px rgba(255,255,255,0.4);
    }

    @media (max-width: 500px) {
      .register-box { padding: 30px 20px; }
    }
  </style>
</head>
<body>
  <!-- Background slideshow -->
  <div class="background-slideshow">
    <img src="/storage/images/malbago.jpg" alt="">
    <img src="/storage/images/poblacion.jpg" alt="">
    <img src="/storage/images/tabagak.jpg" alt="">
    <img src="/storage/images/bunakan.jpg" alt="">
    <img src="/storage/images/kodia.jpg" alt="">
    <img src="/storage/images/tugas.jpg" alt="">
    <img src="/storage/images/san-agustin.jpg" alt="">
    <img src="/storage/images/tarong.jpg" alt="">
    <img src="/storage/images/pili.jpg" alt="">
    <img src="/storage/images/mancilang.jpg" alt="">
    <img src="/storage/images/kaongkod.jpg" alt="">
    <img src="/storage/images/talangnan.jpg" alt="">
  </div>

  <div class="overlay"></div>

  <div class="register-container">
    <div class="register-box">
      <h2>User Registration</h2>
      <div class="register-subtitle">Barangay eBudget Transparency System</div>

      <form method="POST" action="{{ route('user.register.store') }}" enctype="multipart/form-data">
        @csrf
        <img id="preview-image" src="https://ui-avatars.com/api/?name=User" class="profile-preview" alt="Preview">

        <div class="input-group">
          <input type="text" name="full_name" placeholder="Full Name" required>
        </div>

        <div class="input-group">
          <input type="text" name="number" placeholder="Contact Number" required>
        </div>

        <div class="input-group">
          <input type="date" id="birthdate" name="birthdate" required>
        </div>

        <div class="input-group">
          <input type="number" id="age" name="age" placeholder="Age" readonly required>
        </div>

        <div class="input-group">
          <select name="barangay_role" required>
            <option value="">-- Select Barangay --</option>
            @foreach (\App\Models\User::getBarangays() as $key => $name)
              <option value="{{ $key }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

        <div class="input-group">
          <input type="file" name="profile_photo" accept="image/*" onchange="previewFile(event)">
        </div>

        <div class="input-group">
          <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="input-group">
          <input type="password" name="password" id="password" placeholder="Password" required>
          <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
        </div>

        <div class="input-group">
          <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
          <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">👁️</span>
        </div>

        <button type="submit" class="register-btn">Register</button>
      </form>

      <div class="login-link">
        Already have an account? <a href="{{ route('user.login') }}">Login here</a>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('birthdate').addEventListener('change', function () {
      let b = new Date(this.value), t = new Date();
      let age = t.getFullYear() - b.getFullYear();
      let m = t.getMonth() - b.getMonth();
      if (m < 0 || (m === 0 && t.getDate() < b.getDate())) age--;
      document.getElementById('age').value = age >= 0 ? age : "";
    });

    function previewFile(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('preview-image').src = e.target.result;
        reader.readAsDataURL(file);
      }
    }

    function togglePassword(id, icon) {
      const field = document.getElementById(id);
      if (field.type === "password") {
        field.type = "text"; icon.textContent = "🙈";
      } else {
        field.type = "password"; icon.textContent = "👁️";
      }
    }
  </script>
</body>
</html>
