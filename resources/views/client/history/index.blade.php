{{-- adjust this extends to match your layout --}}
@extends('client.layouts.app')

@section('content')
<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                Parking History
            </h1>
            <p class="text-base text-[#6c757d] dark:text-slate-400">
                Review all your completed parking sessions.
            </p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        @if($sessions->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/60">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Date</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Parking Lot</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Start Time</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">End Time</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Cost</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($sessions as $session)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    {{ optional($session->started_at)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    {{ $session->lot->name ?? '—' }}
                                </td>
                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    {{ optional($session->started_at)->format('H:i') }}
                                </td>
                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    {{ optional($session->ended_at)->format('H:i') ?? '—' }}
                                </td>
                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    {{ number_format($session->cost ?? 0, 2) }}
                                </td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                        @if($session->status === 'completed')
                                            bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300
                                        @else
                                            bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300
                                        @endif">
                                        {{ ucfirst($session->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $sessions->links() }}
            </div>
        @else
            <div class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                You have no completed parking sessions yet.
            </div>
        @endif
    </div>
</div>
@endsection
