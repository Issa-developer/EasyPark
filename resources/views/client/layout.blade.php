<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EasyPark - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0033A0",
                        "strath-red": "#CE1126",
                        "strath-yellow": "#FFCC00",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101822",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
</head>

<body class="font-display bg-background-light dark:bg-background-dark text-[#333333] dark:text-slate-200">
<div class="relative flex min-h-screen w-full flex-col">

    {{-- Top Navigation --}}
    <header class="sticky top-0 z-10 w-full bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm border-b border-slate-200 dark:border-slate-800">
        <div class="container mx-auto">
            <div class="flex items-center justify-between whitespace-nowrap px-4 py-3">
                <div class="flex items-center gap-3 text-[#0d131c] dark:text-slate-50">
                    <img src="{{ asset('images/strathmore-logo.png') }}" alt="Strathmore University" class="h-9 w-auto">
                    <div>
                        <p class="text-[10px] font-bold tracking-wider text-strath-red uppercase leading-none">Strathmore University</p>
                        <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">EasyPark</h2>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-9">
                    <a href="{{ route('client.dashboard') }}"
                       class="@if(request()->routeIs('client.dashboard')) text-primary border-b-2 border-primary pb-1 font-bold @else text-[#333333] dark:text-slate-300 hover:text-primary dark:hover:text-primary font-medium @endif text-sm leading-normal">
                        Dashboard
                    </a>
                    <a href="{{ route('client.history.index') }}"
                       class="@if(request()->routeIs('client.history.*')) text-primary border-b-2 border-primary pb-1 font-bold @else text-[#333333] dark:text-slate-300 hover:text-primary dark:hover:text-primary font-medium @endif text-sm leading-normal">
                        Parking History
                    </a>
                    <a href="{{ route('client.vehicles.index') }}"
                       class="@if(request()->routeIs('client.vehicles.*')) text-primary border-b-2 border-primary pb-1 font-bold @else text-[#333333] dark:text-slate-300 hover:text-primary dark:hover:text-primary font-medium @endif text-sm leading-normal">
                        My Vehicles
                    </a>
                    <a href="{{ route('client.payments.index') }}"
                       class="@if(request()->routeIs('client.payments.*')) text-primary border-b-2 border-primary pb-1 font-bold @else text-[#333333] dark:text-slate-300 hover:text-primary dark:hover:text-primary font-medium @endif text-sm leading-normal">
                        Payment
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <button
                        class="flex cursor-pointer items-center justify-center rounded-lg h-10 bg-slate-200 dark:bg-slate-700/50 text-[#333333] dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700 gap-2 text-sm font-bold px-2.5">
                        <span class="material-symbols-outlined text-xl">notifications</span>
                    </button>

                    <a href="{{ route('client.profile.edit') }}"
                       class="flex items-center justify-center rounded-full size-10 bg-primary text-white font-bold text-sm ring-2 ring-transparent hover:ring-primary transition">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-1.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-red-500 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full">
        <div class="container mx-auto px-4 py-8 md:py-12">
            @yield('content')
        </div>
    </main>
</div>

<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
        document.getElementById('darkModeToggle')?.classList.remove('bg-slate-200');
        document.getElementById('darkModeToggle')?.classList.add('bg-primary');
        document.getElementById('toggleDot')?.classList.remove('translate-x-1');
        document.getElementById('toggleDot')?.classList.add('translate-x-6');
    }

    function toggleDarkMode() {
        const html = document.documentElement;
        const toggle = document.getElementById('darkModeToggle');
        const dot = document.getElementById('toggleDot');

        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            toggle.classList.remove('bg-primary');
            toggle.classList.add('bg-slate-200');
            dot.classList.remove('translate-x-6');
            dot.classList.add('translate-x-1');
            localStorage.setItem('theme', 'light');
        } else {
            html.classList.add('dark');
            toggle.classList.remove('bg-slate-200');
            toggle.classList.add('bg-primary');
            dot.classList.remove('translate-x-1');
            dot.classList.add('translate-x-6');
            localStorage.setItem('theme', 'dark');
        }
    }
</script>
</body>
</html>