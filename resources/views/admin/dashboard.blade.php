<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EasyPark - Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
</head>

<body class="font-display bg-background-light text-[#333333]">
<div class="relative flex min-h-screen w-full flex-col">

    {{-- Top Navigation --}}
    <header class="sticky top-0 z-10 w-full bg-white/80 backdrop-blur-sm border-b border-slate-200">
        <div class="container mx-auto">
            <div class="flex items-center justify-between px-4 py-3">
                <div class="flex items-center gap-3 text-[#0d131c]">
                    <img src="{{ asset('images/strathmore-logo.svg') }}" alt="Strathmore University" class="h-9 w-auto">
                    <div>
                        <p class="text-[10px] font-bold tracking-wider text-strath-red uppercase leading-none">Strathmore University</p>
                        <h2 class="text-lg font-bold">EasyPark</h2>
                    </div>
                    <span class="text-xs bg-red-100 text-red-600 font-semibold px-2 py-0.5 rounded-full">Admin</span>
                </div>

                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-sm font-medium text-primary border-b-2 border-primary pb-1">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.sessions') }}"
                       class="text-sm font-medium text-slate-600 hover:text-primary transition">
                        Sessions
                    </a>
                    <a href="{{ route('admin.users') }}"
                       class="text-sm font-medium text-slate-600 hover:text-primary transition">
                        Users
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-500">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-1.5 text-sm font-medium text-slate-600 hover:text-red-500 transition">
                            <span class="material-symbols-outlined text-base">logout</span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full">
        <div class="container mx-auto px-4 py-8">

            {{-- Page Title --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-[#0d131c]">Admin Dashboard</h1>
                <p class="text-slate-500 text-sm mt-1">Overview of all parking activity at Strathmore University</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-base">person</span>
                        </div>
                        <p class="text-sm text-slate-500">Students</p>
                    </div>
                    <p class="text-3xl font-bold text-[#0d131c]">{{ $totalUsers }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600 text-base">security</span>
                        </div>
                        <p class="text-sm text-slate-500">Guards</p>
                    </div>
                    <p class="text-3xl font-bold text-[#0d131c]">{{ $totalSecurity }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-purple-600 text-base">history</span>
                        </div>
                        <p class="text-sm text-slate-500">Total Sessions</p>
                    </div>
                    <p class="text-3xl font-bold text-[#0d131c]">{{ $totalSessions }}</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-yellow-600 text-base">directions_car</span>
                        </div>
                        <p class="text-sm text-slate-500">Active Now</p>
                    </div>
                    <p class="text-3xl font-bold text-[#0d131c]">{{ $totalActive }}</p>
                </div>
            </div>

            {{-- Parking Lot Occupancy --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                @foreach($lots as $lot)
                @php
                    $percent = $lot->total_spots > 0
                        ? round(($lot->occupied / $lot->total_spots) * 100)
                        : 0;
                    $statusColor = $percent >= 90 ? 'bg-strath-red' : ($percent >= 60 ? 'bg-strath-yellow' : 'bg-strath-yellow');
                    $statusBadge = $percent >= 90
                        ? 'bg-red-100 text-red-600'
                        : ($percent >= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-yellow-100 text-yellow-700');
                    $statusText = $percent >= 90 ? 'Almost Full' : ($percent >= 60 ? 'Filling Up' : 'Available');
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-slate-700">{{ $lot->name }}</span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $statusBadge }}">
                            {{ $statusText }}
                        </span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 mb-3">
                        <div class="h-2 rounded-full {{ $statusColor }}"
                             style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500">
                        <span><span class="font-semibold text-yellow-600">{{ $lot->available }}</span> Available</span>
                        <span><span class="font-semibold text-red-500">{{ $lot->occupied }}</span> Occupied</span>
                        <span><span class="font-semibold text-slate-700">{{ $lot->total_spots }}</span> Total</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Active Sessions Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="font-bold text-[#0d131c]">Active Sessions</h2>
                    <a href="{{ route('admin.sessions') }}"
                       class="text-xs text-primary font-medium hover:underline">View all sessions</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-6 py-3 text-left">License Plate</th>
                                <th class="px-6 py-3 text-left">Parking Lot</th>
                                <th class="px-6 py-3 text-left">Spot</th>
                                <th class="px-6 py-3 text-left">Entry Time</th>
                                <th class="px-6 py-3 text-left">Duration</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($activeSessions as $session)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3 font-semibold tracking-widest">
                                    {{ $session->license_plate_snapshot }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">{{ $session->lot->name }}</td>
                                <td class="px-6 py-3 text-slate-600">Spot {{ $session->spot->spot_number }}</td>
                                <td class="px-6 py-3 text-slate-600">
                                    {{ \Carbon\Carbon::parse($session->started_at)->format('h:i A') }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    {{ \Carbon\Carbon::parse($session->started_at)->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">
                                    No active parking sessions
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Create Security Guard Form --}}
            <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="font-bold text-[#0d131c] mb-5">Create Security Guard Account</h2>

                @if(session('guard_success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                        {{ session('guard_success') }}
                    </div>
                @endif
                @if(session('guard_error'))
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                        {{ session('guard_error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.guards.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name</label>
                            <input type="text" name="name"
                                   placeholder="Guard Name"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                   required/>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                            <input type="email" name="email"
                                   placeholder="guard@easypark.com"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                   required/>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                            <input type="password" name="password"
                                   placeholder="Min 6 characters"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                   required/>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                                class="bg-primary hover:bg-[#00267a] text-white font-bold py-2.5 px-6 rounded-xl transition text-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">person_add</span>
                            Create Guard Account
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>
</body>
</html>