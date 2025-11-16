@extends('client.layout')

@section('content')
<div class="flex flex-col gap-8">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                My Vehicles
            </h1>
            <p class="text-base text-[#6c757d] dark:text-slate-400">
                Manage the vehicles registered under your account.
            </p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

        @if($vehicles->count())
            <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($vehicles as $vehicle)
                    <li class="px-6 py-4 flex justify-between items-center hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <div>
                            <p class="text-base font-semibold text-slate-900 dark:text-white">
                                {{ $vehicle->make }} {{ $vehicle->model }}
                            </p>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                Plate: {{ $vehicle->plate_number }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                You haven't added any vehicles yet.
            </div>
        @endif
    </div>
</div>
@endsection
