<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>EasyPark - Register</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="h-full">
<div class="min-h-screen flex flex-col">
    {{-- Top bar --}}
    <header class="w-full flex items-center justify-between px-8 py-4 bg-white border-b">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg"></div>
            <span class="font-bold text-lg">EasyPark</span>
        </div>
        <a href="{{ route('login') }}"
           class="px-4 py-1.5 text-sm rounded-md border border-blue-600 text-blue-600 hover:bg-blue-50">
            Login
        </a>
    </header>

    <main class="flex-1 flex flex-col items-center justify-center px-4">
        <div class="max-w-3xl w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-2">Create your EasyPark Account</h1>
                <p class="text-gray-600">Join us to manage your parking seamlessly.</p>
            </div>

            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 text-red-700 text-sm rounded-lg px-4 py-3 mb-4">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Personal Info --}}
                <section class="bg-white rounded-xl shadow-sm p-6 border">
                    <h2 class="font-semibold mb-4">Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}"
                                   class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password"
                                   class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                   class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </section>

                {{-- Vehicle Info --}}
                <section class="bg-white rounded-xl shadow-sm p-6 border">
                    <h2 class="font-semibold mb-4">Vehicle Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">License Plate Number</label>
                            <input type="text" name="license_plate" value="{{ old('license_plate') }}"
                                   class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Car Make</label>
                            <input type="text" name="car_make" value="{{ old('car_make') }}"
                                   class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Car Model</label>
                            <input type="text" name="car_model" value="{{ old('car_model') }}"
                                   class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </section>

                <button type="submit"
                        class="w-full mt-2 py-3 rounded-md bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                    Sign Up
                </button>

                <p class="text-center text-sm text-gray-600 mt-2">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">
                        Log in
                    </a>
                </p>
            </form>
        </div>
    </main>
</div>
</body>
</html>
