@extends('client.layouts.app')

@section('content')
<div class="flex flex-col gap-8">

    <h1 class="text-3xl md:text-4xl font-black">Edit Profile</h1>

    @if(session('success'))
        <div class="p-4 bg-emerald-100 text-emerald-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('client.profile.update') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-1 text-sm font-medium">Full Name</label>
            <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:border-slate-700">
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:border-slate-700">
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">New Password (optional)</label>
            <input type="password" name="password"
                class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:border-slate-700">
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation"
                class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:border-slate-700">
        </div>

        <button class="px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-blue-600">
            Save Changes
        </button>
    </form>
</div>
@endsection
