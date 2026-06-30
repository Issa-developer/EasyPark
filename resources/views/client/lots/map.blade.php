@extends('client.layout')

@section('title', $lot->name . ' Map')

@section('content')
<div class="flex flex-col gap-6">
    <div>
        <h1 class="text-3xl font-black">{{ $lot->name }} - Spot Map</h1>
        <p class="text-slate-500 text-sm">{{ $lot->location }}</p>
    </div>

    {{-- Legend --}}
    <div class="flex flex-wrap gap-4 bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2 text-sm"><span class="w-4 h-4 rounded bg-green-500"></span> Available</div>
        <div class="flex items-center gap-2 text-sm"><span class="w-4 h-4 rounded bg-red-500"></span> Occupied</div>
        <div class="flex items-center gap-2 text-sm"><span class="w-4 h-4 rounded bg-yellow-400"></span> Reserved</div>
        <div class="flex items-center gap-2 text-sm"><span class="w-4 h-4 rounded bg-gray-400"></span> Out of Service</div>
    </div>

    {{-- Spot Grid --}}
    <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800">
        <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-3">
            @foreach($spots as $spot)
                @php
                    $color = match($spot->status) {
                        'available' => 'bg-green-500',
                        'occupied' => 'bg-red-500',
                        'reserved' => 'bg-yellow-400',
                        default => 'bg-gray-400',
                    };
                @endphp
                <div class="aspect-square rounded-lg {{ $color }} flex items-center justify-center text-white text-xs font-bold shadow-sm"
                     title="Spot {{ $spot->spot_number }} - {{ ucfirst($spot->status) }}">
                    {{ $spot->spot_number }}
                </div>
            @endforeach
        </div>
    </div>

    <a href="{{ route('client.dashboard') }}" class="text-primary text-sm font-medium">← Back to Dashboard</a>
</div>
@endsection
