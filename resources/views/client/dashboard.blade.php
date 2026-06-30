@extends('client.layout')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                Welcome back, {{ $user->name }}
            </h1>
            <p class="text-base text-[#6c757d] dark:text-slate-400">
                Here's a summary of your parking activity.
            </p>
        </div>
    </div>

    {{-- Stats cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-background-dark rounded-xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
            <p class="text-sm text-[#6c757d] dark:text-slate-400 mb-1">Total Sessions</p>
            <p class="text-3xl font-bold">{{ $totalSessions }}</p>
        </div>

        <div class="bg-white dark:bg-background-dark rounded-xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
            <p class="text-sm text-[#6c757d] dark:text-slate-400 mb-1">Active Session</p>
            @if($activeSession)
                <p class="font-semibold">{{ $activeSession->lot->name }} – {{ $activeSession->spot->spot_number }}</p>
                <p class="text-sm text-[#6c757d] dark:text-slate-400">
                    Started {{ $activeSession->started_at->format('M d, Y h:i A') }}
                </p>
            @else
                <p class="text-sm text-[#6c757d] dark:text-slate-400">No active parking session.</p>
            @endif
        </div>
    </div>

    {{-- Navigate from current location --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6">
        <h2 class="text-xl font-bold mb-4">Navigate to Parking Lot</h2>
        <p class="text-sm text-slate-500 mb-4">Select a lot and we'll open directions from your current location.</p>

        <div class="flex flex-col md:flex-row gap-4">
            <select id="navigateLotSelect" class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm">
                <option value="">Choose a parking lot</option>
                @foreach($lots as $lot)
                    @if($lot['latitude'] && $lot['longitude'])
                        <option value="{{ $lot['latitude'] }},{{ $lot['longitude'] }}">
                            {{ $lot['name'] }}
                        </option>
                    @endif
                @endforeach
            </select>

            <button onclick="navigateToLot()"
                    class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition text-sm">
                Open Directions
            </button>
        </div>

        <p id="navigateError" class="hidden text-sm text-red-600 mt-3"></p>
    </div>

    <script>
        function navigateToLot() {
            const select = document.getElementById('navigateLotSelect');
            const error = document.getElementById('navigateError');
            const coords = select.value;

            if (!coords) {
                error.textContent = 'Please select a parking lot first.';
                error.classList.remove('hidden');
                return;
            }

            if (!navigator.geolocation) {
                error.textContent = 'Geolocation is not supported by your browser.';
                error.classList.remove('hidden');
                return;
            }

            error.classList.add('hidden');

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const origin = `${position.coords.latitude},${position.coords.longitude}`;
                    const url = `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${coords}`;
                    window.open(url, '_blank');
                },
                (err) => {
                    error.textContent = 'Unable to retrieve your location: ' + err.message;
                    error.classList.remove('hidden');
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }
    </script>

    {{-- Parking Lot Availability --}}
    <div>
        <h2 class="text-xl font-bold mb-4">Parking Availability</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
            <div class="bg-white dark:bg-background-dark rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-bold text-[#0d131c] dark:text-slate-100 text-sm">{{ $lot['name'] }}</h3>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $statusBadge }}">
                            {{ $statusText }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400">Strathmore University</p>
                </div>
                <div class="px-5 py-4">
                    <div class="text-center mb-3">
                        <p class="text-4xl font-black text-green-500">{{ $lot['available'] }}</p>
                        <p class="text-xs text-slate-500 mt-1">spots available</p>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 mb-3">
                        <div class="h-2.5 rounded-full {{ $statusColor }}"
                             style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-slate-500">
                        <span><span class="font-bold text-green-600">{{ $lot['available'] }}</span> Free</span>
                        <span><span class="font-bold text-red-500">{{ $lot['occupied'] }}</span> Taken</span>
                        <span><span class="font-bold text-slate-700">{{ $lot['total_spots'] }}</span> Total</span>
                        <span><span class="font-bold text-slate-700">{{ $percent }}%</span> Full</span>
                    </div>
                    @if($lot['latitude'] && $lot['longitude'])
                        <a
                            href="https://www.google.com/maps/dir/?api=1&destination={{ $lot['latitude'] }},{{ $lot['longitude'] }}"
                            target="_blank"
                            class="mt-4 block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition"
                        >
                            🧭 Navigate
                        </a>
                    @endif
                    <a href="{{ route('client.lots.map', $lot['id']) }}"
                       class="mt-3 block w-full text-center bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 rounded-lg transition">
                        View Spot Map
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Recent history table (short version) --}}
    <div class="bg-white dark:bg-background-dark rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-x-auto">
        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-800">
            <h2 class="text-lg font-semibold">Recent Sessions</h2>
            <a href="{{ route('client.history.index') }}" class="text-sm text-primary font-medium">
                View all
            </a>
        </div>
        <table class="w-full text-left">
            <thead class="text-sm text-[#6c757d] dark:text-slate-400">
            <tr>
                <th class="p-4">Location</th>
                <th class="p-4">Date</th>
                <th class="p-4">Duration</th>
                <th class="p-4">Cost</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
            @forelse($recentSessions as $session)
                <tr class="text-sm hover:bg-slate-50 dark:hover:bg-slate-800/20">
                    <td class="p-4 font-medium">{{ $session->lot->name }}</td>
                    <td class="p-4">
                        {{ $session->started_at->format('M d, Y, h:i A') }}
                        @if($session->ended_at)
                            – {{ $session->ended_at->format('h:i A') }}
                        @endif
                    </td>
                    <td class="p-4">
                        {{ $session->duration_minutes ? floor($session->duration_minutes/60).'h '.($session->duration_minutes%60).'m' : '-' }}
                    </td>
                    <td class="p-4 font-semibold">${{ number_format($session->cost, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-sm text-[#6c757d] dark:text-slate-400">
                        No completed sessions yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection