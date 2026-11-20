<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4 antialiased selection:bg-indigo-500/30 selection:text-indigo-200">
    <div
        class="w-full max-w-md bg-slate-900/90 border border-slate-800/90 rounded-2xl shadow-2xl shadow-black/40 p-6 sm:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-100">Create Account</h1>
                <p class="text-xs sm:text-sm text-slate-400">Start organizing your tasks in seconds</p>
            </div>
        </div>

        <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="username"
                    class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                    Username
                </label>
                <div class="relative">
                    <x-lucide-user
                        class="h-4 w-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                    <input id="username" type="text" name="username" value="{{ old('username') }}"
                        placeholder="Choose a username" required autofocus
                        class="w-full h-11 bg-slate-950/70 border-2 border-slate-700/90 rounded-xl pl-10 pr-4 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                </div>
                @error('username')
                    <p class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium mt-1.5">
                        <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div>
                <label for="password"
                    class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                    Password
                </label>
                <div class="relative">
                    <x-lucide-lock
                        class="h-4 w-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                    <input id="password" type="password" name="password" placeholder="Create a password" required
                        class="w-full h-11 bg-slate-950/70 border-2 border-slate-700/90 rounded-xl pl-10 pr-11 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                    <button type="button" data-toggle-password="password" aria-label="Toggle password visibility"
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
                    Confirm Password
                </label>
                <div class="relative">
                    <x-lucide-shield-check
                        class="h-4 w-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" />
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        placeholder="Repeat your password" required
                        class="w-full h-11 bg-slate-950/70 border-2 border-slate-700/90 rounded-xl pl-10 pr-11 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                    <button type="button" data-toggle-password="password_confirmation"
                        aria-label="Toggle password confirmation visibility"
                        class="absolute right-2.5 top-1/2 -translate-y-1/2 h-7 w-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-200 hover:bg-slate-800/80 focus:outline-none transition-colors cursor-pointer">
                        <x-lucide-eye data-eye-open class="h-4 w-4" />
                        <x-lucide-eye-off data-eye-closed class="h-4 w-4 hidden" />
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full h-11 inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 border-2 border-indigo-500/80 hover:border-indigo-400 text-white rounded-xl font-semibold shadow-sm shadow-indigo-950/50 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 active:scale-[0.98] transition-all duration-200 ease-out cursor-pointer mt-2">
                <x-lucide-user-plus class="h-4 w-4" />
                <span>Register</span>
            </button>
        </form>

        <div class="border-t border-slate-800 mt-6 pt-5 text-center">
            <p class="text-slate-400 text-sm">
                Already have an account?
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-1 text-indigo-400 hover:text-indigo-300 font-semibold transition-colors">
                    <x-lucide-arrow-left class="h-3.5 w-3.5" />
                    <span>Login</span>
                </a>
            </p>
        </div>
    </div>

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