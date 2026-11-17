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

<body class="bg-slate-950 min-h-screen py-12 px-4">

    <div class="max-w-xl mx-auto bg-slate-800 rounded-xl shadow-md overflow-hidden p-6">
        <h1 class="text-2xl font-bold text-slate-100 mb-6">Public To-Do List (temporaily)</h1>

        @if (session('success'))
            <p
                class="bg-emerald-500/20 border-2 border-emerald-500/40 p-2 rounded-xl text-sm font-bold text-center text-green-300/60 tracking-wide mb-3 mt-1">
                {{ session('success') }}
            </p>
        @endif


        <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="title" placeholder="What needs to be done?" required
                class="flex-1 rounded-xl border border-slate-300 px-4 py-2 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-8 py-2 rounded-lg transition cursor-pointer">
                Add
            </button>
        </form>

        @error('title')
            <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
        @enderror


        <ul class="divide-y divide-slate-600 space-y-3">
            @forelse ($tasks as $task)
                <li class="bg-slate-700/80 p-3 rounded-xl">
                    <div class="flex items-center justify-between gap-3">
                        <form action="{{ route('tasks.update', $task) }}" method="POST"
                            class="flex items-center gap-3 flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="flex items-center gap-3 text-left cursor-pointer group">
                                <span
                                    class="h-5 w-5 rounded-full border-2 flex items-center justify-center {{ $task->is_completed ? 'bg-indigo-500 border-indigo-600 text-white' : 'border-slate-300 group-hover:border-indigo-500' }}">
                                    @if($task->is_completed)
                                        <x-lucide-check />
                                    @endif
                                </span>
                                <span
                                    class="{{ $task->is_completed ? 'line-through text-slate-400' : 'text-slate-100' }} font-medium tracking-tight">
                                    {{ $task->title }}
                                </span>
                            </button>
                        </form>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('tasks.index', ['edit' => $task->id]) }}"
                                class="text-sm text-indigo-400 hover:text-indigo-300 font-medium">
                                Edit
                            </a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-sm text-rose-500 hover:text-rose-400 font-medium cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    @if ($editingTask == $task->id)
                        <form action="{{ route('tasks.edit', $task) }}" method="POST"
                            class="mt-4 pt-3 border-t border-slate-600">
                            @csrf
                            @method('PUT')

                            <label class="text-slate-400 text-sm font-bold tracking-wide">Task Title</label>
                            <input type="text" name="title" value="{{ $task->title }}" required
                                class="w-full rounded-xl border border-slate-500 bg-slate-800 px-4 py-2 text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            @error('title')
                                <p class="text-rose-400 text-sm mt-2">{{ $message }}</p>
                            @enderror

                            <div class="flex justify-end gap-2 mt-3">
                                <a href="{{ route('tasks.index') }}"
                                    class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white text-sm font-medium">
                                    Cancel
                                </a>

                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    @endif
                </li>
            @empty
                <li class="py-6 text-center text-slate-400">
                    No tasks yet. Add one above to get started!
                </li>
            @endforelse
        </ul>

    </div>

</body>

</html>