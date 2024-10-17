<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        // Validate and store the task
        $task = Task::create($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:todo,in progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
        ]));

        return response()->json([
            'success' => true,
            'task' => $task,
            'html' => view('tasks.partials.task-card', ['task' => $task])->render(),
            'stats' => $this->getQuickStats(),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:todo,in progress,done',
        ]);

        $task->update($validatedData);

        return response()->json([
            'success' => true,
            'stats' => $this->getQuickStats(),
        ]);
    }

    public function getStats()
    {
        return response()->json($this->getQuickStats());
    }

    private function getQuickStats()
    {
        return [
            'total' => Task::count(),
            'todo' => Task::where('status', 'todo')->count(),
            'in_progress' => Task::where('status', 'in progress')->count(),
            'completed' => Task::where('status', 'done')->count(),
        ];
    }
}