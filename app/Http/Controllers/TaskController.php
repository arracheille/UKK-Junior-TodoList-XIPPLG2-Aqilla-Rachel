<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $tasks = $request->validate([
            'task' => 'required|string',
            'description' => 'nullable|string',
            'priority' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $tasks['task'] = $request->task;
        $tasks['description'] = $request->description;
        $tasks['priority'] = $request->priority;
        $tasks['due_date'] = $request->due_date;
        $tasks['status'] = $request->status;

        Task::create($tasks);

        return redirect()->route('task.index');
    }

    public function edit(Task $task)
    {
        return view('tasks.index', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $tasks = $request->validate([
            'task' => 'nullable|string',
            'description' => 'nullable|string',
            'priority' => 'nullable',
            'due_date' => 'nullable|date',
            'status' => 'nullable|boolean',
        ]);

        $task->update($tasks);

        return redirect()->route('task.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index')->with('success', 'Task berhasil dihapus');
    }
}
