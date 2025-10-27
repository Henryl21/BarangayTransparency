<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officer Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center min-h-screen">
    <form method="POST" action="{{ route('officer.login.submit') }}"
          class="bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-xl w-96 border border-green-200">
        @csrf

        <h2 class="text-3xl font-bold text-center mb-6 text-green-700">Officer Login</h2>

        <!-- SweetAlert Errors -->
        @if ($errors->has('email') && str_contains($errors->first('email'), 'Please try again in'))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const message = {!! json_encode($errors->first('email')) !!};
                    const match = message.match(/(\d+)\s*seconds/);
                    let seconds = match ? parseInt(match[1]) : 60;

                    Swal.fire({
                        icon: 'warning',
                        title: 'Too Many Attempts',
                        html: `<p>Please wait <b><span id="countdown">${seconds}</span></b> seconds before trying again.</p>`,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            const countdown = Swal.getHtmlContainer().querySelector('#countdown');
                            const timer = setInterval(() => {
                                seconds--;
                                countdown.textContent = seconds;
                                if (seconds <= 0) {
                                    clearInterval(timer);
                                    Swal.close();
                                    location.reload();
                                }
                            }, 1000);
                        }
                    });
                });
            </script>
        @elseif ($errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonColor: '#16a34a'
                    });
                });
            </script>
        @endif

        <!-- Role -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Role</label>
            <select name="role" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
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

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" name="email" type="email" required placeholder="Enter your email"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" name="password" type="password" required placeholder="Enter your password"
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-4">
            <input type="checkbox" name="remember" id="remember" class="mr-2 rounded text-green-600 focus:ring-green-500">
            <label for="remember" class="text-sm text-gray-700">Remember Me</label>
        </div>

        <button type="submit"
                class="w-full bg-green-600 text-white p-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Login
        </button>

        <div class="mt-4 text-center">
            <a href="{{ route('officer.forgot.password') }}" class="text-green-600 text-sm hover:underline">
                Forgot Password?
            </a>
        </div>

        <p class="mt-4 text-center text-sm text-gray-700">
            Don’t have an account?
            <a href="{{ route('officer.register') }}" class="text-green-600 font-medium hover:underline">Register</a>
        </p>
    </form>
</body>
</html>
