<!DOCTYPE html>
<html>
<head>
    <title>Officer Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form action="{{ route('officer.login.submit') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md w-96">
        @csrf
        <h2 class="text-2xl font-bold mb-6 text-center">Officer Login</h2>

        <!-- Email Input -->
        <input type="email" name="email" placeholder="Email" class="w-full p-3 border rounded mb-4" required>

        <!-- Password Input -->
        <input type="password" name="password" placeholder="Password" class="w-full p-3 border rounded mb-6" required>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center mb-4">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember">Remember Me</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-green-600 text-white p-3 rounded hover:bg-green-700">Login</button>

        <!-- Forgot Password Link -->
        <div class="mt-4 text-center">
            <a href="{{ route('officer.forgot.password') }}" class="text-blue-500 text-sm">Forgot Password?</a>
        </div>

        <!-- Register Link -->
        <p class="mt-4 text-center text-sm">Don’t have an account?
            <a href="{{ route('officer.register') }}" class="text-blue-500">Register</a>
        </p>
    </form>
</body>
</html>