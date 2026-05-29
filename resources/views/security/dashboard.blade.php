<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EasyPark - Parking Availability</title>
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
                        "primary": "#1973f0",
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
                <div class="flex items-center gap-4 text-[#0d131c]">
                    <div class="size-6 text-primary">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                  d="M24 4H42V17.3333V30.6667H24V44H6V30.6667V17.3333H24V4Z"
                                  fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold">EasyPark</h2>
                    <span class="text-xs bg-purple-100 text-purple-600 font-semibold px-2 py-0.5 rounded-full">Student</span>
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
                <h1 class="text-2xl font-bold text-[#0d131c]">Parking Availability</h1>
                <p class="text-slate-500 text-sm mt-1">Real-time parking spot availability across Strathmore University</p>
            </div>

            {{-- Summary Bar --}}
            @php
                $totalAvailable = collect($lots)->sum('available');
                $totalSpots = collect($lots)->sum('total_spots');
                $totalOccupied = collect($lots)->sum('occupied');
            @endphp
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-center">
                    <p class="text-3xl font-bold text-green-500">{{ $totalAvailable }}</p>
                    <p class="text-sm text-slate-500 mt-1">Total Available</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-center">
                    <p class="text-3xl font-bold text-red-500">{{ $totalOccupied }}</p>
                    <p class="text-sm text-slate-500 mt-1">Total Occupied</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-center">
                    <p class="text-3xl font-bold text-slate-700">{{ $totalSpots }}</p>
                    <p class="text-sm text-slate-500 mt-1">Total Capacity</p>
                </div>
            </div>

            {{-- Parking Lot Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($lots as $lot)
                @php
                    $percent = $lot['total_spots'] > 0
                        ? round(($lot['occupied'] / $lot['total_spots']) * 100)
                        : 0;
                    $statusColor = $percent >= 90 ? 'bg-red-500' : ($percent >= 60 ? 'bg-yellow-400' : 'bg-green-500');
                    $statusText = $percent >= 90 ? 'Almost Full' : ($percent >= 60 ? 'Filling Up' : 'Available');
                    $statusBadge = $percent >= 90
                        ? 'bg-red-100 text-red-600'
                        : ($percent >= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700');
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                    {{-- Card Header --}}
                    <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                        <div class="flex items-start justify-between mb-1">
                            <h3 class="font-bold text-[#0d131c] text-base">{{ $lot['name'] }}</h3>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $statusBadge }}">
                                {{ $statusText }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400">Strathmore University</p>
                    </div>

                    {{-- Occupancy Visual --}}
                    <div class="px-6 py-5">

                        {{-- Big available number --}}
                        <div class="text-center mb-4">
                            <p class="text-5xl font-black text-green-500">{{ $lot['available'] }}</p>
                            <p class="text-sm text-slate-500 mt-1">spots available</p>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-slate-100 rounded-full h-3 mb-4">
                            <div class="h-3 rounded-full {{ $statusColor }} transition-all"
                                 style="width: {{ $percent }}%"></div>
                        </div>

                        {{-- Stats Row --}}
                        <div class="flex justify-between text-xs text-slate-500">
                            <div class="text-center">
                                <p class="font-bold text-green-600 text-sm">{{ $lot['available'] }}</p>
                                <p>Free</p>
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-red-500 text-sm">{{ $lot['occupied'] }}</p>
                                <p>Taken</p>
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-slate-700 text-sm">{{ $lot['total_spots'] }}</p>
                                <p>Total</p>
                            </div>
                            <div class="text-center">
                                <p class="font-bold text-slate-700 text-sm">{{ $percent }}%</p>
                                <p>Full</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Last updated note --}}
            <p class="text-center text-xs text-slate-400 mt-8">
                <span class="material-symbols-outlined text-xs align-middle">schedule</span>
                Data updates every time you refresh the page
            </p>

        </div>
    </main>
</div>
</body>
</html>