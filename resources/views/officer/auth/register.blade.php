<!DOCTYPE html>
<html>
<head>
    <title>Officer Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form action="{{ route('officer.register.submit') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md w-96">
        @csrf
        <h2 class="text-2xl font-bold mb-6 text-center">Officer Register</h2>

        <input type="text" name="name" placeholder="Full Name" class="w-full p-3 border rounded mb-4" required>
        <input type="email" name="email" placeholder="Email" class="w-full p-3 border rounded mb-4" required>
        <input type="text" name="position" placeholder="Position" class="w-full p-3 border rounded mb-4">
        <input type="password" name="password" placeholder="Password" class="w-full p-3 border rounded mb-4" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full p-3 border rounded mb-6" required>

        <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700">Register</button>

        <p class="mt-4 text-center text-sm">Already have an account?
            <a href="{{ route('officer.login') }}" class="text-blue-500">Login</a>
        </p>
    </form>
</body>
</html>
