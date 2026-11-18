<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4">
    <div class="bg-slate-800 rounded-xl p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-white mb-6">Welcome Back</h1>

        <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-4">
            @csrf

            <input type="text" name="username" value="{{ old('username') }}" placeholder="Username" required
                class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white">

            <input type="password" name="password" placeholder="Password" required
                class="w-full bg-slate-700 border border-slate-600 rounded-xl px-4 py-3 text-white">

            @error('username')
                <p class="text-rose-400 text-sm">{{ $message }}</p>
            @enderror

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl py-3 font-semibold">
                Login
            </button>
        </form>

        <p class="text-slate-400 text-sm mt-5 text-center">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-400">Register</a>
        </p>
    </div>
</body>

</html>