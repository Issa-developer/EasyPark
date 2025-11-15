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
                Here’s a summary of your parking activity.
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
