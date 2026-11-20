<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between py-10 sm:py-14 px-4 antialiased selection:bg-indigo-500/30 selection:text-indigo-200">
    <main class="w-full max-w-xl mx-auto">
        <div
            class="bg-slate-900/90 border border-slate-800/90 rounded-2xl shadow-2xl shadow-black/40 overflow-hidden p-5 sm:p-7">

            <header class="flex items-start justify-between gap-4 pb-6 mb-6 border-b border-slate-800">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="min-w-0">
                        <h1 class="text-2xl font-bold tracking-tight text-slate-100">Profile Settings</h1>
                        <p class="text-xs sm:text-sm text-slate-400 mt-0.5">Manage your account information</p>
                    </div>
                </div>

                <a href="{{ route('tasks.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl px-3 py-2 text-xs sm:text-sm font-medium text-indigo-400 hover:text-indigo-300 bg-indigo-500/10 hover:bg-indigo-500/15 border border-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 active:scale-95 transition-all duration-200 shrink-0">
                    <x-lucide-arrow-left class="h-4 w-4" />
                    <span>Back to tasks</span>
                </a>
            </header>

            @if (session('success'))
                <div id="success-wrapper"
                    class="grid grid-rows-[0fr] opacity-0 -translate-y-2 transition-all duration-500 ease-out">
                    <div class="overflow-hidden">
                        <div
                            class="flex items-center justify-center gap-2 bg-emerald-500/15 border border-emerald-500/35 px-4 py-2.5 rounded-xl text-sm font-semibold text-emerald-300 tracking-wide mb-5">
                            <x-lucide-circle-check class="h-4 w-4 shrink-0 text-emerald-400" />
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const alertBox = document.getElementById('success-wrapper');
                        if (!alertBox) return;

                        setTimeout(() => {
                            alertBox.classList.remove('grid-rows-[0fr]', 'opacity-0', '-translate-y-2');
                            alertBox.classList.add('grid-rows-[1fr]', 'opacity-100', 'translate-y-0');
                        }, 30);

                        setTimeout(() => {
                            alertBox.classList.remove('grid-rows-[1fr]', 'opacity-100', 'translate-y-0');
                            alertBox.classList.add('grid-rows-[0fr]', 'opacity-0', '-translate-y-2');
                            setTimeout(() => alertBox.remove(), 500);
                        }, 4000);
                    });
                </script>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="bg-slate-950/50 border border-slate-800/90 rounded-2xl p-3.5 sm:p-4 space-y-4">
                    <div>
                        <label for="displayname"
                            class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                            Display Name
                        </label>
                        <div class="relative">
                            <x-lucide-smile
                                class="h-4 w-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input id="displayname" type="text" name="displayname"
                                value="{{ old('displayname', auth()->user()->displayname) }}" required
                                class="w-full h-11 bg-slate-950/80 border-2 border-slate-700/90 rounded-xl pl-10 pr-4 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                        </div>
                        @error('displayname')
                            <p class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium mt-1.5">
                                <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="username"
                            class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                            Username
                        </label>
                        <div class="relative">
                            <x-lucide-user
                                class="h-4 w-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                            <input id="username" type="text" name="username"
                                value="{{ old('username', auth()->user()->username) }}" required
                                class="w-full h-11 bg-slate-950/80 border-2 border-slate-700/90 rounded-xl pl-10 pr-4 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                        </div>
                        @error('username')
                            <p class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium mt-1.5">
                                <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="bg-slate-950/50 border border-slate-800/90 rounded-2xl p-3.5 sm:p-4">
                    <div class="flex items-center gap-2 mb-1">
                        <h2 class="font-semibold text-slate-100">Change Password</h2>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-400 mb-4">
                        Leave these fields empty if you don't want to change your password.
                    </p>

                    <div class="space-y-4">
                        <div>
                            <label for="current_password"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                                Current Password
                            </label>
                            <div class="relative">
                                <x-lucide-lock
                                    class="h-4 w-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                                <input id="current_password" type="password" name="current_password"
                                    autocomplete="current-password" placeholder="Enter current password"
                                    class="w-full h-11 bg-slate-950/80 border-2 border-slate-700/90 rounded-xl pl-10 pr-11 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                                <button type="button" data-toggle-password="current_password"
                                    aria-label="Toggle current password visibility"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 h-7 w-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-200 hover:bg-slate-800/80 focus:outline-none transition-colors cursor-pointer">
                                    <x-lucide-eye data-eye-open class="h-4 w-4" />
                                    <x-lucide-eye-off data-eye-closed class="h-4 w-4 hidden" />
                                </button>
                            </div>
                            @error('current_password')
                                <p class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium mt-1.5">
                                    <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="password"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                                New Password
                            </label>
                            <div class="relative">
                                <x-lucide-lock
                                    class="h-4 w-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                                <input id="password" type="password" name="password" autocomplete="new-password"
                                    placeholder="Enter new password"
                                    class="w-full h-11 bg-slate-950/80 border-2 border-slate-700/90 rounded-xl pl-10 pr-11 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                                <button type="button" data-toggle-password="password"
                                    aria-label="Toggle new password visibility"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 h-7 w-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-200 hover:bg-slate-800/80 focus:outline-none transition-colors cursor-pointer">
                                    <x-lucide-eye data-eye-open class="h-4 w-4" />
                                    <x-lucide-eye-off data-eye-closed class="h-4 w-4 hidden" />
                                </button>
                            </div>
                            @error('password')
                                <p class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium mt-1.5">
                                    <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <x-lucide-shield-check
                                    class="h-4 w-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    autocomplete="new-password" placeholder="Repeat new password"
                                    class="w-full h-11 bg-slate-950/80 border-2 border-slate-700/90 rounded-xl pl-10 pr-11 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                                <button type="button" data-toggle-password="password_confirmation"
                                    aria-label="Toggle confirm new password visibility"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 h-7 w-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-200 hover:bg-slate-800/80 focus:outline-none transition-colors cursor-pointer">
                                    <x-lucide-eye data-eye-open class="h-4 w-4" />
                                    <x-lucide-eye-off data-eye-closed class="h-4 w-4 hidden" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl border-2 border-indigo-500/80 hover:border-indigo-500 bg-transparent hover:bg-indigo-500 text-indigo-400 hover:text-slate-950 font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500/40 active:scale-95 transition-all duration-200 ease-out cursor-pointer">
                        <x-lucide-save class="h-4 w-4" />
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="w-full max-w-xl mx-auto text-center text-slate-400 pt-6">
        <div class="flex flex-wrap justify-center items-center gap-3">
            <a class="inline-flex items-center gap-2 rounded-xl py-2 px-4 bg-slate-900/70 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/60 text-xs sm:text-sm font-medium text-slate-300 hover:text-indigo-400 active:scale-95 transition-all duration-200"
                href="https://github.com/SanityGuy/todolist" target="_blank" rel="noopener noreferrer">
                <x-lucide-code class="h-4 w-4 text-indigo-400" />
                Source Code
            </a>
            <a class="inline-flex items-center gap-2 rounded-xl py-2 px-4 bg-slate-900/70 hover:bg-slate-900 border border-slate-800 hover:border-indigo-500/60 text-xs sm:text-sm font-medium text-slate-300 hover:text-indigo-400 active:scale-95 transition-all duration-200"
                href="https://saweria.co/souyandev" target="_blank" rel="noopener noreferrer">
                <x-lucide-coffee class="h-4 w-4 text-indigo-400" />
                Support Me
            </a>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-toggle-password]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const input = document.getElementById(btn.dataset.togglePassword);
                    if (!input) return;

                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';

                    btn.querySelector('[data-eye-open]')?.classList.toggle('hidden', isHidden);
                    btn.querySelector('[data-eye-closed]')?.classList.toggle('hidden', !isHidden);
                });
            });
        });
    </script>
</body>

</html>