<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $tasks = $request->validate([
            'task' => 'required',
            'priority' => 'required',
            'due_date' => 'required',
            'status' => 'required',
        ]);

        $tasks['task'] = $request->task;
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

    public function update(Task $task)
    {
        $task->update(['status' => 1]);

        return redirect()->route('task.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index')->with('success', 'Task berhasil dihapus!');
    }
}
