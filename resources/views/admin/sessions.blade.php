<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EasyPark - All Sessions</title>
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
            theme: {
                extend: {
                    colors: {
                        "primary": "#0033A0",
                        "strath-red": "#CE1126",
                        "strath-yellow": "#FFCC00",
                        "background-light": "#f6f7f8",
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-background-light text-[#333333]">
<div class="relative flex min-h-screen w-full flex-col">

    {{-- Header --}}
    <header class="sticky top-0 z-10 w-full bg-white/80 backdrop-blur-sm border-b border-slate-200">
        <div class="container mx-auto">
            <div class="flex items-center justify-between px-4 py-3">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/strathmore-logo.svg') }}" alt="Strathmore University" class="h-9 w-auto">
                    <div>
                        <p class="text-[10px] font-bold tracking-wider text-strath-red uppercase leading-none">Strathmore University</p>
                        <h2 class="text-lg font-bold">EasyPark</h2>
                    </div>
                    <span class="text-xs bg-red-100 text-red-600 font-semibold px-2 py-0.5 rounded-full">Admin</span>
                </div>

                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-sm font-medium text-slate-600 hover:text-primary transition">Dashboard</a>
                    <a href="{{ route('admin.sessions') }}"
                       class="text-sm font-medium text-primary border-b-2 border-primary pb-1">Sessions</a>
                    <a href="{{ route('admin.users') }}"
                       class="text-sm font-medium text-slate-600 hover:text-primary transition">Users</a>
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

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-[#0d131c]">All Parking Sessions</h1>
                    <p class="text-slate-500 text-sm mt-1">Search and filter all vehicle sessions</p>
                </div>
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center justify-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2 px-4 rounded-xl transition text-sm">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Back to Dashboard
                </a>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('admin.sessions') }}"
                  class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">License Plate</label>
                        <input type="text" name="plate" value="{{ request('plate') }}"
                               placeholder="e.g. KDA 123A"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Status</label>
                        <select name="status"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Parking Lot</label>
                        <select name="lot_id"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">All Lots</option>
                            @foreach($lots as $lot)
                                <option value="{{ $lot->id }}" {{ request('lot_id') == $lot->id ? 'selected' : '' }}>
                                    {{ $lot->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="flex-1 bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl transition text-sm">
                            Search
                        </button>
                        <a href="{{ route('admin.sessions') }}"
                           class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-4 rounded-xl transition text-sm">
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            {{-- Sessions Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="font-bold text-[#0d131c]">Sessions</h2>
                    <span class="text-xs text-slate-500">{{ $sessions->total() }} total records</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-6 py-3 text-left">License Plate</th>
                                <th class="px-6 py-3 text-left">Parking Lot</th>
                                <th class="px-6 py-3 text-left">Spot</th>
                                <th class="px-6 py-3 text-left">Entry Time</th>
                                <th class="px-6 py-3 text-left">Exit Time</th>
                                <th class="px-6 py-3 text-left">Duration</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($sessions as $session)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3 font-semibold tracking-widest">
                                    {{ $session->license_plate_snapshot }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">{{ $session->lot->name }}</td>
                                <td class="px-6 py-3 text-slate-600">Spot {{ $session->spot->spot_number }}</td>
                                <td class="px-6 py-3 text-slate-600">
                                    {{ \Carbon\Carbon::parse($session->started_at)->format('M d, h:i A') }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    {{ $session->ended_at ? \Carbon\Carbon::parse($session->ended_at)->format('M d, h:i A') : '—' }}
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    {{ $session->duration_minutes ? floor($session->duration_minutes/60).'h '.($session->duration_minutes%60).'m' : '—' }}
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                        {{ $session->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($session->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-400 text-sm">
                                    No sessions found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($sessions->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $sessions->withQueryString()->links() }}
                </div>
                @endif
            </div>

        </div>
    </main>
</div>
</body>
</html>