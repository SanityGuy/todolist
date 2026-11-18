@php
    $editingTask = request('edit');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 min-h-screen py-12 px-4 antialiased">

    <div class="max-w-xl mx-auto bg-slate-800 rounded-xl shadow-lg overflow-hidden p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-100">
                Public To-Do List
            </h1>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-slate-800 border-2 border-rose-500 p-2 px-3 rounded-xl text-rose-500 font-medium tracking-wide hover:text-slate-900 hover:bg-rose-500 hover:border-rose-600 active:scale-95 transition-all duration-200 ease-out cursor-pointer">
                    Logout
                </button>
            </form>
        </div>

        @if (session('success'))
            <div id="success-wrapper"
                class="grid grid-rows-[0fr] opacity-0 -translate-y-2 transition-all duration-500 ease-out">
                <div class="overflow-hidden">
                    <p
                        class="bg-emerald-500/20 border-2 border-emerald-500/40 p-2 rounded-xl text-sm font-bold text-center text-green-300/80 tracking-wide mb-4 mt-1">
                        {{ session('success') }}
                    </p>
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

        <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="title" placeholder="What needs to be done?" required
                class="flex-1 bg-slate-900/50 rounded-2xl border-2 border-slate-600 px-4 py-2 text-slate-100 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
            <button type="submit"
                class="bg-slate-800 hover:bg-indigo-500 border-2 border-indigo-500 hover:border-indigo-600 text-white font-medium px-6 py-2 rounded-xl active:scale-95 transition-all duration-200 ease-out cursor-pointer">
                Add
            </button>
        </form>

        @error('title')
            <p class="text-rose-400 text-sm mb-4">{{ $message }}</p>
        @enderror

        <ul class="space-y-3">
            @forelse ($tasks as $task)
                <li class="bg-slate-700/80 hover:bg-slate-700 p-3.5 rounded-xl transition-colors duration-200 ease-out">
                    <div class="flex items-center justify-between gap-3">
                        <form action="{{ route('tasks.update', $task) }}" method="POST"
                            class="flex items-center gap-3 flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="flex items-center gap-3 text-left cursor-pointer group">
                                <span
                                    class="h-5 w-5 rounded-full border-2 flex items-center justify-center {{ $task->is_completed ? 'bg-indigo-500 border-indigo-600 text-white' : 'border-slate-400 group-hover:border-indigo-400' }} transition-all duration-200 ease-out">
                                    @if ($task->is_completed)
                                        <x-lucide-check class="w-3.5 h-3.5" />
                                    @endif
                                </span>
                                <span
                                    class="{{ $task->is_completed ? 'line-through text-slate-400' : 'text-slate-100' }} font-medium tracking-tight transition-colors duration-200 ease-out">
                                    {{ $task->title }}
                                </span>
                            </button>
                        </form>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('tasks.index', ['edit' => $task->id]) }}"
                                class="text-sm text-indigo-400 hover:text-indigo-300 font-bold tracking-wide transition-colors duration-200">
                                Edit
                            </a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-sm text-rose-500 hover:text-rose-400 font-bold tracking-wide transition-colors duration-200 cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    @if ($editingTask == $task->id)
                        <div id="edit-dropdown-{{ $task->id }}"
                            class="grid grid-rows-[0fr] opacity-0 -translate-y-2 transition-all duration-300 ease-out">
                            <div class="overflow-hidden">
                                <form action="{{ route('tasks.edit', $task) }}" method="POST"
                                    class="mt-4 pt-3 border-t border-slate-600">
                                    @csrf
                                    @method('PUT')

                                    <label class="text-slate-400 text-sm font-bold tracking-wide">Task Title</label>
                                    <input type="text" name="title" value="{{ $task->title }}" required autofocus
                                        class="w-full bg-slate-800 rounded-2xl border-2 border-slate-500 px-4 py-2 text-slate-100 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out mt-1">

                                    @error('title')
                                        <p class="text-rose-400 text-sm mt-2">{{ $message }}</p>
                                    @enderror

                                    <div class="flex justify-end gap-2 mt-3">
                                        <a href="{{ route('tasks.index') }}" id="cancel-edit-{{ $task->id }}"
                                            class="px-4 py-2 rounded-lg bg-rose-500 hover:bg-rose-600 text-white text-sm font-medium active:scale-95 transition-all duration-200 ease-out">
                                            Cancel
                                        </a>

                                        <button type="submit"
                                            class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium active:scale-95 transition-all duration-200 ease-out cursor-pointer">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const dropdown = document.getElementById('edit-dropdown-{{ $task->id }}');
                                const cancelBtn = document.getElementById('cancel-edit-{{ $task->id }}');
                                if (!dropdown) return;

                                setTimeout(() => {
                                    dropdown.classList.remove('grid-rows-[0fr]', 'opacity-0', '-translate-y-2');
                                    dropdown.classList.add('grid-rows-[1fr]', 'opacity-100', 'translate-y-0');
                                }, 30);

                                if (cancelBtn) {
                                    cancelBtn.addEventListener('click', (e) => {
                                        e.preventDefault();
                                        dropdown.classList.remove('grid-rows-[1fr]', 'opacity-100', 'translate-y-0');
                                        dropdown.classList.add('grid-rows-[0fr]', 'opacity-0', '-translate-y-2');
                                        setTimeout(() => {
                                            window.location.href = cancelBtn.href;
                                        }, 280);
                                    });
                                }
                            });
                        </script>
                    @endif
                </li>
            @empty
                <li class="text-center text-slate-400 py-8 text-sm">
                    No tasks yet. Add one above to get started.
                </li>
            @endforelse
        </ul>
    </div>
</body>
<footer class="w-full text-center text-white mt-5">
    <div class="flex flex-wrap justify-center items-center gap-3">
        <a class="inline-flex items-center gap-1.5 rounded-xl py-2 px-4 bg-slate-900/60 hover:bg-slate-900 border-2 border-slate-700 hover:border-indigo-600 text-sm font-medium text-indigo-500 hover:text-indigo-400 active:scale-95 active:bg-indigo-500 active:border-indigo-600/80 active:text-slate-900 transition duration-200"
            href="https://github.com/SanityGuy/todolist" target="_blank" rel="noopener noreferrer">
            <x-lucide-code class="h-5 w-5" />
            Source Code
        </a>
        <a class="inline-flex items-center gap-1.5 rounded-xl py-2 px-4 bg-slate-900/60 hover:bg-slate-900 border-2 border-slate-700 hover:border-indigo-600 text-sm font-medium text-indigo-500 hover:text-indigo-400 active:scale-95 active:bg-indigo-500 active:border-indigo-600/80 active:text-slate-900 transition duration-200"
            href="https://github.com/SanityGuy/todolist" target="_blank" rel="noopener noreferrer">
            <x-lucide-coffee class="h-5 w-5" />
            Support Me
        </a>
    </div>
</footer>

</html>