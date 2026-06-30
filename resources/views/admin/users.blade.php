<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EasyPark - Users</title>
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
                    <img src="{{ asset('images/strathmore-logo.png') }}" alt="Strathmore University" class="h-9 w-auto">
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
                       class="text-sm font-medium text-slate-600 hover:text-primary transition">Sessions</a>
                    <a href="{{ route('admin.users') }}"
                       class="text-sm font-medium text-primary border-b-2 border-primary pb-1">Users</a>
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

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-[#0d131c]">Users</h1>
                <p class="text-slate-500 text-sm mt-1">All security guards and students registered in the system</p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-base">security</span>
                        </div>
                        <p class="text-sm text-slate-500">Security Guards</p>
                    </div>
                    <p class="text-3xl font-bold">{{ $users->where('role', 'security')->count() }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-base">school</span>
                        </div>
                        <p class="text-sm text-slate-500">Students/Lecturers</p>
                    </div>
                    <p class="text-3xl font-bold">{{ $users->where('role', 'client')->count() }}</p>
                </div>
            </div>

            {{-- Users Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="font-bold text-[#0d131c]">All Users</h2>
                    <span class="text-xs text-slate-500">{{ $users->count() }} total users</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Role</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-3 font-semibold">{{ $user->name }}</td>
                                <td class="px-6 py-3 text-slate-600">{{ $user->email }}</td>
                                <td class="px-6 py-3">
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                        {{ $user->role === 'security' ? 'bg-blue-100 text-primary' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $user->role === 'security' ? 'Security Guard' : 'Student/Lecturer' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                        {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">
                                    No users found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>
</body>
</html>