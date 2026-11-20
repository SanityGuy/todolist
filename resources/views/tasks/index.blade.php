@php
    $editingTask = request('edit');
    $completedCount = $tasks->where('is_completed', true)->count();
    $totalCount = $tasks->count();
@endphp

<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-slate-950 text-slate-100 min-h-screen flex flex-col justify-between py-10 sm:py-14 px-4 antialiased selection:bg-indigo-500/30 selection:text-indigo-200">

    <main class="w-full max-w-xl mx-auto">
        <div
            class="bg-slate-900/90 border border-slate-800/90 rounded-2xl shadow-2xl shadow-black/40 overflow-hidden p-5 sm:p-7">

            <header class="flex items-start justify-between gap-4 pb-6 mb-6 border-b border-slate-800">
                <div class="min-w-0">
                    <h1 class="text-2xl font-bold tracking-tight text-slate-100">
                        To-Do List
                    </h1>
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 mt-1.5 text-xs sm:text-sm text-slate-400">
                        @if (auth()->user()->tasks()->exists())
                            <p id="task-counter">
                                <span data-completed-count class="font-semibold text-slate-200">{{ $completedCount }}</span>
                                of <span data-total-count class="font-semibold text-slate-200">{{ $totalCount }}</span>
                                completed
                            </p>
                            <span class="text-slate-700" aria-hidden="true">•</span>
                        @endif
                        <a href="{{ route('profile') }}"
                            class="inline-flex items-center gap-1.5 text-indigo-400 hover:text-indigo-300 font-medium transition-colors">
                            <x-lucide-user class="h-3.5 w-3.5 shrink-0" />
                            <span class="truncate">{{ auth()->user()->displayname }}</span>
                        </a>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit" aria-label="Log out" title="Log out"
                        class="inline-flex items-center justify-center h-10 w-10 rounded-xl border-2 border-rose-500/80 hover:border-rose-500 bg-transparent hover:bg-rose-500 text-rose-500 hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-rose-500/40 active:scale-95 transition-all duration-200 ease-out cursor-pointer">
                        <x-lucide-log-out class="h-5 w-5" />
                    </button>
                </form>
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

            <form action="{{ route('tasks.store') }}" method="POST"
                class="bg-slate-950/50 border border-slate-800/90 rounded-2xl p-3.5 sm:p-4 space-y-3 mb-6">
                @csrf

                <div class="flex items-center gap-2.5">
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="What needs to be done?"
                        required
                        class="flex-1 min-w-0 h-11 bg-slate-950/80 rounded-xl border-2 border-slate-700/90 px-4 text-sm sm:text-base text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                    <button type="submit" aria-label="Add task" title="Add task"
                        class="inline-flex items-center justify-center h-11 w-11 shrink-0 rounded-xl border-2 border-indigo-500/80 hover:border-indigo-500 bg-transparent hover:bg-indigo-500 text-indigo-400 hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 active:scale-95 transition-all duration-200 ease-out cursor-pointer">
                        <x-lucide-circle-plus class="h-5 w-5" />
                    </button>
                </div>

                @error('title')
                    <p class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium">
                        <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                        <span>{{ $message }}</span>
                    </p>
                @enderror

                <div>
                    <label for="notes"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                        <x-lucide-sticky-note class="h-3.5 w-3.5 text-slate-500" />
                        <span>Notes (Optional)</span>
                    </label>
                    <textarea id="notes" name="notes" rows="2" maxlength="5000"
                        placeholder="Add some details about this task..."
                        class="w-full bg-slate-950/80 border-2 border-slate-700/90 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium mt-1.5">
                            <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>
            </form>

            <ul class="space-y-2.5">
                @forelse ($tasks as $task)
                    <li
                        class="group/item bg-slate-800/75 hover:bg-slate-800 border border-slate-700/60 hover:border-slate-600/80 p-3.5 sm:px-4 rounded-xl transition-all duration-200 ease-out">
                        <div class="flex items-start justify-between gap-3">
                            <form action="{{ route('tasks.update', $task) }}" method="POST"
                                class="flex-1 min-w-0 js-task-toggle">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="flex items-start gap-3 text-left w-full min-w-0 cursor-pointer group"
                                    aria-pressed="{{ $task->is_completed ? 'true' : 'false' }}">
                                    <span data-check-circle
                                        class="mt-0.5 h-5 w-5 shrink-0 rounded-full border-2 flex items-center justify-center transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)] {{ $task->is_completed ? 'bg-indigo-500 border-indigo-500 text-white scale-105' : 'border-slate-400 group-hover:border-indigo-400 group-hover:scale-105' }}">
                                        <x-lucide-check data-check-icon
                                            class="w-3.5 h-3.5 stroke-[3] transition-all duration-200 ease-[cubic-bezier(0.34,1.56,0.64,1)] {{ $task->is_completed ? 'scale-100 opacity-100 rotate-0' : 'scale-0 opacity-0 -rotate-12' }}" />
                                    </span>

                                    <div class="min-w-0 flex-1">
                                        <span data-check-label
                                            class="block truncate font-medium tracking-tight transition-colors duration-300 ease-out {{ $task->is_completed ? 'line-through text-slate-400' : 'text-slate-100' }}">
                                            {{ $task->title }}
                                            @if ($task->notes)
                                                <p class="text-xs sm:text-sm text-slate-400 mt-1 break-words leading-relaxed">
                                                    {{ $task->notes }}
                                                </p>
                                            @endif
                                        </span>
                                    </div>
                                </button>
                            </form>

                            <div class="flex items-center gap-1.5 shrink-0">
                                <a href="{{ $editingTask == $task->id ? route('tasks.index') : route('tasks.index', ['edit' => $task->id]) }}"
                                    data-edit-toggle="{{ $task->id }}" data-index-url="{{ route('tasks.index') }}"
                                    aria-label="Edit task" title="Edit task"
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-indigo-400 hover:text-indigo-300 hover:bg-indigo-500/15 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 active:scale-95 transition-all duration-200">
                                    <x-lucide-pencil class="h-4 w-4" />
                                </a>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Delete task" title="Delete task"
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-rose-500 hover:text-rose-400 hover:bg-rose-500/15 focus:outline-none focus:ring-2 focus:ring-rose-500/40 active:scale-95 transition-all duration-200 cursor-pointer">
                                        <x-lucide-trash class="h-4 w-4" />
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if ($editingTask == $task->id)
                            <div id="edit-dropdown-{{ $task->id }}" data-open="true"
                                class="grid grid-rows-[0fr] opacity-0 -translate-y-2 transition-all duration-300 ease-out">
                                <div class="overflow-hidden">
                                    <form action="{{ route('tasks.edit', $task) }}" method="POST"
                                        class="mt-4 pt-4 border-t border-slate-700/80 space-y-3.5">
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label for="edit-input-{{ $task->id }}"
                                                class="block text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1.5">
                                                Task Title
                                            </label>
                                            <input id="edit-input-{{ $task->id }}" type="text" name="title"
                                                value="{{ old('title', $task->title) }}" placeholder="What's the new title?"
                                                required autofocus
                                                class="w-full h-10 bg-slate-900/90 rounded-xl border-2 border-slate-600 px-3.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">
                                            @error('title')
                                                <p
                                                    class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium mt-1.5">
                                                    <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                                                    <span>{{ $message }}</span>
                                                </p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="notes-{{ $task->id }}"
                                                class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">
                                                <x-lucide-sticky-note class="h-3.5 w-3.5 text-slate-500" />
                                                <span>Notes (Optional)</span>
                                            </label>
                                            <textarea id="notes-{{ $task->id }}" name="notes" rows="3" maxlength="5000"
                                                placeholder="Add some details about this task..."
                                                class="w-full bg-slate-900/90 border-2 border-slate-600 rounded-xl px-3.5 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition-all duration-200 ease-out">{{ old('notes', $task->notes) }}</textarea>
                                            @error('notes')
                                                <p
                                                    class="flex items-center gap-1.5 text-rose-400 text-xs sm:text-sm font-medium mt-1.5">
                                                    <x-lucide-alert-circle class="h-4 w-4 shrink-0" />
                                                    <span>{{ $message }}</span>
                                                </p>
                                            @enderror
                                        </div>

                                        <div class="flex items-center justify-end gap-2 pt-1">
                                            <a href="{{ route('tasks.index') }}" id="cancel-edit-{{ $task->id }}"
                                                aria-label="Cancel editing" title="Cancel"
                                                class="inline-flex items-center justify-center h-10 w-10 rounded-xl border-2 border-rose-500/80 hover:border-rose-500 bg-transparent hover:bg-rose-500 text-rose-500 hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-rose-500/40 active:scale-95 transition-all duration-200 ease-out">
                                                <x-lucide-circle-x class="h-5 w-5" />
                                            </a>

                                            <button type="submit" aria-label="Save task changes" title="Save changes"
                                                class="inline-flex items-center justify-center h-10 w-10 rounded-xl border-2 border-indigo-500/80 hover:border-indigo-500 bg-transparent hover:bg-indigo-500 text-indigo-400 hover:text-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 active:scale-95 transition-all duration-200 ease-out cursor-pointer">
                                                <x-lucide-save class="h-5 w-5" />
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const dropdown = document.getElementById('edit-dropdown-{{ $task->id }}');
                                    const cancelBtn = document.getElementById('cancel-edit-{{ $task->id }}');
                                    const editBtn = document.querySelector('[data-edit-toggle="{{ $task->id }}"]');
                                    if (!dropdown) return;

                                    let isClosing = false;

                                    const expandDropdown = () => {
                                        isClosing = false;
                                        dropdown.dataset.open = 'true';
                                        requestAnimationFrame(() => {
                                            dropdown.classList.remove('grid-rows-[0fr]', 'opacity-0', '-translate-y-2');
                                            dropdown.classList.add('grid-rows-[1fr]', 'opacity-100', 'translate-y-0');
                                        });
                                    };

                                    const collapseAndNavigate = (targetUrl) => {
                                        if (isClosing) return;
                                        isClosing = true;
                                        dropdown.dataset.open = 'false';
                                        dropdown.classList.remove('grid-rows-[1fr]', 'opacity-100', 'translate-y-0');
                                        dropdown.classList.add('grid-rows-[0fr]', 'opacity-0', '-translate-y-2');
                                        setTimeout(() => {
                                            window.location.href = targetUrl;
                                        }, 280);
                                    };

                                    setTimeout(expandDropdown, 30);

                                    if (cancelBtn) {
                                        cancelBtn.addEventListener('click', (e) => {
                                            e.preventDefault();
                                            collapseAndNavigate(cancelBtn.href);
                                        });
                                    }

                                    if (editBtn) {
                                        editBtn.addEventListener('click', (e) => {
                                            e.preventDefault();
                                            if (dropdown.dataset.open === 'true') {
                                                collapseAndNavigate(editBtn.dataset.indexUrl);
                                            } else {
                                                expandDropdown();
                                            }
                                        });
                                    }
                                });
                            </script>
                        @endif
                    </li>
                @empty
                    <li
                        class="flex flex-col items-center justify-center text-center py-12 px-4 rounded-xl border border-dashed border-slate-800 text-slate-400">
                        <x-lucide-clipboard-list class="h-8 w-8 text-slate-600 mb-2.5" />
                        <p class="text-sm font-medium text-slate-300">No tasks yet</p>
                        <p class="text-xs text-slate-500 mt-1">Add a task above to get started.</p>
                    </li>
                @endforelse
            </ul>
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
            const completedEl = document.querySelector('[data-completed-count]');

            const updateCompletedCounter = (delta) => {
                if (!completedEl) return;
                const current = parseInt(completedEl.textContent, 10) || 0;
                completedEl.textContent = String(Math.max(0, current + delta));
            };

            document.querySelectorAll('.js-task-toggle').forEach((form) => {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const btn = form.querySelector('button[type="submit"]');
                    const circle = form.querySelector('[data-check-circle]');
                    const icon = form.querySelector('[data-check-icon]');
                    const label = form.querySelector('[data-check-label]');

                    const isCurrentlyChecked = btn.getAttribute('aria-pressed') === 'true';
                    const nextChecked = !isCurrentlyChecked;

                    btn.setAttribute('aria-pressed', String(nextChecked));
                    updateCompletedCounter(nextChecked ? 1 : -1);

                    circle.classList.toggle('bg-indigo-500', nextChecked);
                    circle.classList.toggle('border-indigo-500', nextChecked);
                    circle.classList.toggle('text-white', nextChecked);
                    circle.classList.toggle('scale-105', nextChecked);
                    circle.classList.toggle('border-slate-400', !nextChecked);

                    icon.classList.toggle('scale-100', nextChecked);
                    icon.classList.toggle('opacity-100', nextChecked);
                    icon.classList.toggle('rotate-0', nextChecked);
                    icon.classList.toggle('scale-0', !nextChecked);
                    icon.classList.toggle('opacity-0', !nextChecked);
                    icon.classList.toggle('-rotate-12', !nextChecked);

                    label.classList.toggle('line-through', nextChecked);
                    label.classList.toggle('text-slate-400', nextChecked);
                    label.classList.toggle('text-slate-100', !nextChecked);

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json, text/html',
                            },
                            body: new FormData(form),
                        });

                        if (!response.ok) {
                            throw new Error('Failed to toggle task');
                        }
                    } catch (err) {
                        btn.setAttribute('aria-pressed', String(isCurrentlyChecked));
                        updateCompletedCounter(nextChecked ? -1 : 1);

                        circle.classList.toggle('bg-indigo-500', isCurrentlyChecked);
                        circle.classList.toggle('border-indigo-500', isCurrentlyChecked);
                        circle.classList.toggle('text-white', isCurrentlyChecked);
                        circle.classList.toggle('scale-105', isCurrentlyChecked);
                        circle.classList.toggle('border-slate-400', !isCurrentlyChecked);

                        icon.classList.toggle('scale-100', isCurrentlyChecked);
                        icon.classList.toggle('opacity-100', isCurrentlyChecked);
                        icon.classList.toggle('rotate-0', isCurrentlyChecked);
                        icon.classList.toggle('scale-0', !isCurrentlyChecked);
                        icon.classList.toggle('opacity-0', !isCurrentlyChecked);
                        icon.classList.toggle('-rotate-12', !isCurrentlyChecked);

                        label.classList.toggle('line-through', isCurrentlyChecked);
                        label.classList.toggle('text-slate-400', isCurrentlyChecked);
                        label.classList.toggle('text-slate-100', !isCurrentlyChecked);
                    }
                });
            });
        });
    </script>
</body>

</html>