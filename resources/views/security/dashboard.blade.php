<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EasyPark - Security Dashboard</title>
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
                    <img src="{{ asset('images/strathmore-logo.png') }}" alt="Strathmore University" class="h-9 w-auto">
                    <div>
                        <p class="text-[10px] font-bold tracking-wider text-strath-red uppercase leading-none">Strathmore University</p>
                        <h2 class="text-lg font-bold">EasyPark</h2>
                    </div>
                    <span class="text-xs bg-yellow-100 text-yellow-700 font-semibold px-2 py-0.5 rounded-full">Security</span>
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
                <h1 class="text-2xl font-bold text-[#0d131c]">Security Dashboard</h1>
                <p class="text-slate-500 text-sm mt-1">Log vehicle entry and exit across all parking lots</p>
            </div>

            {{-- Lot Occupancy Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                @foreach($lots as $lot)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-slate-700">{{ $lot['name'] }}</span>
                        @php
                            $percent = $lot['total_spots'] > 0
                                ? round(($lot['occupied'] / $lot['total_spots']) * 100)
                                : 0;
                            $color = $percent >= 90 ? 'bg-strath-red' : ($percent >= 60 ? 'bg-strath-yellow' : 'bg-strath-yellow');
                        @endphp
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full
                            {{ $percent >= 90 ? 'bg-red-100 text-red-600' : ($percent >= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $percent }}% Full
                        </span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 mb-3">
                        <div class="h-2 rounded-full {{ $color }} transition-all"
                             style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500">
                        <span><span class="font-semibold text-yellow-600">{{ $lot['available'] }}</span> Available</span>
                        <span><span class="font-semibold text-red-500">{{ $lot['occupied'] }}</span> Occupied</span>
                        <span><span class="font-semibold text-slate-700">{{ $lot['total_spots'] }}</span> Total</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Entry / Exit Forms --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Log Entry --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600 text-base">login</span>
                        </div>
                        <h2 class="text-base font-bold text-[#0d131c]">Log Vehicle Entry</h2>
                    </div>

                    @if(session('entry_success'))
                        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                            {{ session('entry_success') }}
                        </div>
                    @endif
                    @if(session('entry_error'))
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                            {{ session('entry_error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('security.entry') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">License Plate</label>
                            <input type="text" name="license_plate"
                                   placeholder="e.g. KDA 123A"
                                   value="{{ old('license_plate') }}"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required/>
                            @error('license_plate')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Parking Lot</label>
                            <select name="parking_lot_id"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    required>
                                <option value="">Select a parking lot</option>
                                @foreach($lots as $lot)
                                    <option value="{{ $lot['id'] }}">
                                        {{ $lot['name'] }} ({{ $lot['available'] }} spots available)
                                    </option>
                                @endforeach
                            </select>
                            @error('parking_lot_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 px-4 rounded-xl transition text-sm flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">directions_car</span>
                            Log Entry
                        </button>
                    </form>
                </div>

                {{-- Log Exit --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-red-500 text-base">logout</span>
                        </div>
                        <h2 class="text-base font-bold text-[#0d131c]">Log Vehicle Exit</h2>
                    </div>

                    @if(session('exit_success'))
                        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                            {{ session('exit_success') }}
                        </div>
                    @endif
                    @if(session('exit_error'))
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                            {{ session('exit_error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('security.exit') }}">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">License Plate</label>
                            <input type="text" name="license_plate"
                                   placeholder="e.g. KDA 123A"
                                   value="{{ old('license_plate') }}"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                   required/>
                            @error('license_plate')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 px-4 rounded-xl transition text-sm flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">directions_car</span>
                            Log Exit
                        </button>
                    </form>
                </div>
            </div>

            {{-- Active Sessions Table --}}
            <div class="mt-8 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="font-bold text-[#0d131c]">Active Sessions</h2>
                    <span class="text-xs text-slate-500">{{ count($activeSessions) }} vehicles currently parked</span>
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

        </div>
    </main>
</div>
</body>
</html>