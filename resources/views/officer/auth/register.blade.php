<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center min-h-screen">

    <form action="{{ route('officer.register.submit') }}" method="POST"
          class="bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-xl w-96 border border-green-200">
        @csrf

        <h2 class="text-3xl font-bold text-center mb-6 text-green-700">Officer Registration</h2>

        <!-- Full Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
        </div>

        <!-- Position (optional) -->
        <div class="mb-4">
            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position (Optional)</label>
            <input type="text" id="position" name="position" placeholder="Enter your position (if any)"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <!-- Role Dropdown -->
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Select Role</label>
            <select name="role" id="role"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                <option value="" disabled selected>Select Role</option>
                <option value="Officer">Officer</option>
                <option value="Captain">Captain</option>
                <option value="Kagawad">Kagawad</option>
                <option value="SK Chairperson">SK Chairperson</option>
                <option value="Treasurer">Treasurer</option>
                <option value="Clerk">Clerk</option>
                <option value="Record Keeper">Record Keeper</option>
                <option value="Tanod">Tanod</option>
                <option value="Health Worker">Health Worker</option>
                <option value="Nutrition Scholar">Nutrition Scholar</option>
                <option value="Day Care Worker">Day Care Worker</option>
                <option value="IT Officer">IT Officer</option>
                <option value="DRRMO">DRRMO</option>
                <option value="Utility Worker">Utility Worker</option>
            </select>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="w-full bg-green-600 text-white p-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Register
        </button>

        <!-- Login Link -->
        <p class="mt-4 text-center text-sm text-gray-700">
            Already have an account?
            <a href="{{ route('officer.login') }}" class="text-green-600 font-medium hover:underline">Login</a>
        </p>
    </form>

</body>
</html>
