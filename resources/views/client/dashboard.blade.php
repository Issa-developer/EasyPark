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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-background-dark rounded-xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
            <p class="text-sm text-[#6c757d] dark:text-slate-400 mb-1">Total Sessions</p>
            <p class="text-3xl font-bold">{{ $totalSessions }}</p>
        </div>

        <div class="bg-white dark:bg-background-dark rounded-xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm">
            <p class="text-sm text-[#6c757d] dark:text-slate-400 mb-1">Total Spent</p>
            <p class="text-3xl font-bold">${{ number_format($totalSpent, 2) }}</p>
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