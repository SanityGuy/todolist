<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen p-4 sm:p-8 antialiased">
    <main class="max-w-xl mx-auto bg-slate-900/90 border border-slate-800 rounded-2xl shadow-2xl p-6 sm:p-8">
        <div class="flex items-center justify-between mb-7">
            <div>
                <h1 class="text-2xl font-bold">Profile Settings</h1>
                <p class="text-sm text-slate-400 mt-1">Manage your account information</p>
            </div>
            <a href="{{ route('tasks.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300">Back to tasks</a>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="displayname"
                    class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Display
                    Name</label>
                <input id="displayname" type="text" name="displayname"
                    value="{{ old('displayname', auth()->user()->displayname) }}" required
                    class="w-full h-11 bg-slate-950 border border-slate-700 rounded-xl px-4 text-slate-100 focus:outline-none focus:border-indigo-500">
                @error('displayname')
                <p class="text-rose-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="username"
                    class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username', auth()->user()->username) }}"
                    required
                    class="w-full h-11 bg-slate-950 border border-slate-700 rounded-xl px-4 text-slate-100 focus:outline-none focus:border-indigo-500">
                @error('username')
                <p class="text-rose-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="border-t border-slate-800 pt-5">
                <h2 class="font-semibold text-slate-200">Change Password</h2>
                <p class="text-sm text-slate-400 mt-1 mb-4">Leave these fields empty if you don't want to change your
                    password.</p>

                <div class="space-y-4">
                    <div>
                        <label for="current_password"
                            class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Current
                            Password</label>
                        <input id="current_password" type="password" name="current_password"
                            autocomplete="current-password"
                            class="w-full h-11 bg-slate-950 border border-slate-700 rounded-xl px-4 text-slate-100 focus:outline-none focus:border-indigo-500">
                        @error('current_password')
                        <p class="text-rose-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password"
                            class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">New
                            Password</label>
                        <input id="password" type="password" name="password" autocomplete="new-password"
                            class="w-full h-11 bg-slate-950 border border-slate-700 rounded-xl px-4 text-slate-100 focus:outline-none focus:border-indigo-500">
                        @error('password')
                        <p class="text-rose-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Confirm New
                            Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            autocomplete="new-password"
                            class="w-full h-11 bg-slate-950 border border-slate-700 rounded-xl px-4 text-slate-100 focus:outline-none focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full h-11 bg-indigo-600 hover:bg-indigo-500 rounded-xl font-semibold text-white transition-colors">
                Save Changes
            </button>
        </form>
    </main>
</body>

</html>