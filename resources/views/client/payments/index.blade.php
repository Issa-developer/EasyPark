@extends('client.layouts.app')

@section('content')
<div class="flex flex-col gap-8">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                Payment History
            </h1>
            <p class="text-base text-[#6c757d] dark:text-slate-400">
                Review all your payments for parking sessions.
            </p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

        @if($payments->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/60">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Date</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Amount</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Method</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Reference</th>
                            <th class="px-6 py-3 font-semibold text-slate-600 dark:text-slate-300">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/60">
                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    {{ $payment->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>

                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    {{ ucfirst($payment->method) }}
                                </td>

                                <td class="px-6 py-3 text-slate-800 dark:text-slate-200">
                                    {{ $payment->reference }}
                                </td>

                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                        @if($payment->status === 'successful')
                                            bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300
                                        @elseif($payment->status === 'pending')
                                            bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300
                                        @else
                                            bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $payments->links() }}
            </div>
        @else
            <div class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                No payments have been recorded yet.
            </div>
        @endif
    </div>
</div>
@endsection
