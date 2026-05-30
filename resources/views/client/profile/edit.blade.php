@extends('client.layout')

@section('title', 'My Profile')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Page Title --}}
    <h1 class="text-2xl font-bold text-[#0d131c]">My Profile</h1>
{{-- Profile Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <div class="flex items-center gap-4">
            
            {{-- Avatar Circle --}}
            <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-white text-2xl font-black">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            {{-- Name and Email --}}
            <div>
                <h2 class="text-lg font-bold text-[#0d131c]">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
                <span class="text-xs bg-purple-100 text-purple-600 font-semibold px-2 py-0.5 rounded-full">
                    Student
                </span>
            </div>

        </div>
    </div>
    {{-- Edit Form --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <h2 class="text-base font-bold text-[#0d131c] mb-5">Edit Information</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('client.profile.update') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name</label>
                <input type="text" name="full_name"
                       value="{{ old('full_name', $user->name) }}"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                       required/>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
                <input type="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                       required/>
            </div>

            {{-- New Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">New Password <span class="text-slate-400 font-normal">(leave blank to keep current)</span></label>
                <input type="password" name="password"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
            </div>

            <button type="submit"
                    class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition text-sm">
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection