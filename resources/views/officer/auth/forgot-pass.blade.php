<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Officer Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-2xl rounded-2xl p-10 w-96 transform transition-all hover:scale-[1.02] duration-500 ease-in-out">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Forgot Password</h2>
        <p class="text-center text-gray-500 mb-6 text-sm">Enter your email to receive a reset link.</p>

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('officer.forgot.password.send') }}" class="space-y-4">
            @csrf
            <div>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Your email" 
                    required 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 transform hover:translate-y-[-2px] shadow-md"
            >
                Send Reset Link
            </button>

            <p class="text-center text-sm mt-4">
                <a href="{{ route('officer.login') }}" class="text-blue-500 hover:underline">Back to Login</a>
            </p>
        </form>
    </div>

    {{-- SweetAlert Notifications --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#1f2937'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `
                    {!! implode('<br>', $errors->all()) !!}
                `,
                confirmButtonColor: '#2563eb',
                background: '#ffffff',
                color: '#1f2937'
            });
        </script>
    @endif
</body>
</html>
