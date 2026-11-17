<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success','Task created successfully!');
    }

    public function update(Task $task)
    {
        $task->update([
            'is_completed' => !$task->is_completed,
        ]);

        return redirect()->route('tasks.index')->with('success','');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success','Task deleted successfully!');
    }
}
