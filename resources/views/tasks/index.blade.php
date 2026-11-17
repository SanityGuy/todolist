<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel To-Do List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen py-12 px-4">

    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">My To-Do List</h1>

        <!-- Add Task Form -->
        <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="title" placeholder="What needs to be done?" required
                class="flex-1 rounded-lg border border-slate-300 px-4 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg transition cursor-pointer">
                Add
            </button>
        </form>

        <!-- Validation Error -->
        @error('title')
            <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
        @enderror

        <!-- Task List -->
        <ul class="divide-y divide-slate-200">
            @forelse ($tasks as $task)
                <li class="py-3 flex items-center justify-between gap-3">
                    <!-- Toggle Complete -->
                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="flex items-center gap-3 flex-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="flex items-center gap-3 text-left cursor-pointer group">
                            <span
                                class="w-5 h-5 rounded border flex items-center justify-center {{ $task->is_completed ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 group-hover:border-indigo-500' }}">
                                @if($task->is_completed)
                                    ✓
                                @endif
                            </span>
                            <span class="{{ $task->is_completed ? 'line-through text-slate-400' : 'text-slate-700' }}">
                                {{ $task->title }}
                            </span>
                        </button>
                    </form>

                    <!-- Delete Task -->
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-rose-500 hover:text-rose-700 font-medium cursor-pointer">
                            Delete
                        </button>
                    </form>
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