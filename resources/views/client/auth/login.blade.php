<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>EasyPark - Login</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="h-full">
<div class="min-h-screen flex">
    {{-- Left panel --}}
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 lg:px-24 bg-white">
        <div class="mb-8 flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg"></div>
            <span class="font-bold text-lg">EasyPark</span>
        </div>

        <h1 class="text-2xl font-semibold mb-2">Log in to your Account</h1>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-6 mt-6">
            @csrf

            @if($errors->any())
                <div class="bg-red-50 text-red-700 text-sm rounded-lg px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                       class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="remember" class="text-gray-700">Remember me</label>
                </div>
                <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
            </div>

            <button type="submit"
                    class="w-full py-2.5 rounded-md bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                Login
            </button>

            <p class="text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">
                    Sign Up
                </a>
            </p>
        </form>
    </div>

    {{-- Right image panel --}}
    <div class="hidden lg:block lg:w-1/2">
        <img src="{{ asset('images/parking-login.png') }}" class="w-full h-full object-cover" alt="Parking">
    </div>
</div>
</body>
</html>
