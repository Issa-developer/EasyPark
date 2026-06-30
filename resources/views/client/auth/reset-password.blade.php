<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>EasyPark - Reset Password</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#1973f0",
                        "background-light": "#f6f7f8",
                    },
                },
            },
        }
    </script>
</head>
<body class="h-full bg-background-light">
<div class="min-h-screen flex">

    {{-- Left panel --}}
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 lg:px-24 bg-white shadow-sm">

        {{-- Logo --}}
        <div class="mb-10 flex items-center gap-3">
            <div class="w-9 h-9 bg-primary rounded-xl flex items-center justify-center">
                <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white">
                    <path clip-rule="evenodd"
                          d="M24 4H42V17.3333V30.6667H24V44H6V30.6667V17.3333H24V4Z"
                          fill="currentColor" fill-rule="evenodd"></path>
                </svg>
            </div>
            <span class="font-bold text-xl text-[#0d131c]">EasyPark</span>
        </div>

        <h1 class="text-2xl font-bold text-[#0d131c] mb-1">Reset Password</h1>
        <p class="text-sm text-slate-500 mb-8">Choose a new password for your account.</p>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Status Message --}}
            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="you@strathmore.edu"
                       class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary transition">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
                <input type="password" name="password"
                       placeholder="••••••••"
                       class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary transition">
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                       placeholder="••••••••"
                       class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-primary focus:ring-primary transition">
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full py-2.5 rounded-xl bg-primary hover:bg-blue-700 text-white font-semibold text-sm transition shadow-sm">
                Reset Password
            </button>
        </form>
    </div>

    {{-- Right image panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-primary items-center justify-center relative overflow-hidden">
        <img src="{{ asset('images/parking-login.png') }}"
             class="w-full h-full object-cover opacity-30 absolute inset-0" alt="Parking">
        <div class="relative z-10 text-center px-12">
            <h2 class="text-4xl font-black text-white leading-tight mb-4">
                Smart Parking<br/>for Strathmore
            </h2>
            <p class="text-blue-100 text-sm leading-relaxed">
                Real-time parking availability across all campus lots.
                Know before you go.
            </p>
            <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                <div class="bg-white/10 rounded-2xl p-4">
                    <p class="text-2xl font-black text-white">320</p>
                    <p class="text-xs text-blue-100 mt-1">Student Spots</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-4">
                    <p class="text-2xl font-black text-white">80</p>
                    <p class="text-xs text-blue-100 mt-1">Phase 1 Spots</p>
                </div>
                <div class="bg-white/10 rounded-2xl p-4">
                    <p class="text-2xl font-black text-white">40</p>
                    <p class="text-xs text-blue-100 mt-1">SBS Spots</p>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
