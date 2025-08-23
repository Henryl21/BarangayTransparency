<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
        }
        
        .register-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }
        
        .register-box h2 {
            color: white;
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 2px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }
        
        .register-box input[type="text"],
        .register-box input[type="email"],
        .register-box input[type="password"] {
            width: 100%;
            padding: 15px 20px;
            padding-right: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .register-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .register-box input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }
        
        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
        }
        
        /* Profile photo upload styles */
        .photo-upload-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }
        
        .photo-upload-label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input {
            position: absolute;
            left: -9999px;
            opacity: 0;
        }
        
        .file-input-button {
            display: block;
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px dashed rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .file-input-button:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
        }
        
        .file-input-button.has-file {
            border-style: solid;
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
        
        .photo-preview {
            margin-top: 15px;
            text-align: center;
        }
        
        .photo-preview img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
        }
        
        .register-box button {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .register-box button:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .error-message {
            background: rgba(255, 107, 107, 0.2);
            border: 1px solid rgba(255, 107, 107, 0.4);
            color: #ffcccb;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .error-message div {
            margin-bottom: 4px;
        }
        
        .error-message div:last-child {
            margin-bottom: 0;
        }
        
        .login-link {
            margin-top: 25px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }
        
        .login-link a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .login-link a:hover {
            color: rgba(255, 255, 255, 0.8);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        /* Icons using CSS */
        .user-icon::before {
            content: "👤";
        }
        
        .email-icon::before {
            content: "✉";
        }
        
        .lock-icon::before {
            content: "🔒";
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Admin Register</h2>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.register') }}" enctype="multipart/form-data">
            @csrf
            <div class="input-group">
                <input type="text" name="name" placeholder="Admin Name" required value="{{ old('name') }}">
                <div class="input-icon user-icon"></div>
            </div>
            
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                <div class="input-icon email-icon"></div>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
                <div class="input-icon lock-icon"></div>
            </div>
            
            <div class="input-group">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                <div class="input-icon lock-icon"></div>
            </div>
            
            <div class="photo-upload-group">
                <label class="photo-upload-label">Profile Photo (Optional)</label>
                <div class="file-input-wrapper">
                    <input type="file" name="profile_photo" class="file-input" id="profile_photo" accept="image/*">
                    <label for="profile_photo" class="file-input-button" id="file-button">
                        📸 Choose Profile Photo
                    </label>
                </div>
                <div class="photo-preview" id="photo-preview" style="display: none;">
                    <img id="preview-image" src="" alt="Profile Preview">
                </div>
            </div>
            
            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Already have an account?
            <a href="{{ route('admin.login') }}">Login here</a>
        </div>
    </div>

    <script>
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileButton = document.getElementById('file-button');
            const photoPreview = document.getElementById('photo-preview');
            const previewImage = document.getElementById('preview-image');
            
            if (file) {
                // Update button text and style
                fileButton.textContent = `📸 ${file.name}`;
                fileButton.classList.add('has-file');
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    photoPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                // Reset if no file selected
                fileButton.textContent = '📸 Choose Profile Photo';
                fileButton.classList.remove('has-file');
                photoPreview.style.display = 'none';
            }
        });
    </script>
</body>
</html>