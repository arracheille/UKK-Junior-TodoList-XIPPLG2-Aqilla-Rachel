<?php

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $tasks = Task::query();

    if ($request->filled('filter_status') && $request->filter_status !== 'all') {
        $tasks->where('status', $request->filter_status === 'done' ? 1 : 0);
    }

    if ($request->filled('filter_priority') && $request->filter_priority !== 'all') {
        $tasks->where('priority', $request->filter_priority);
    }

    if ($request->filled('search')) {
        $searchbar = $request->search;
        $tasks->where(function($query) use ($searchbar) {
            $query->where('task', 'like', '%' . $searchbar . '%')
                  ->orWhere('status', 'like', '%' . $searchbar . '%')
                  ->orWhere('priority', 'like', '%' . $searchbar . '%')
                  ->orWhere('due_date', 'like', '%' . $searchbar . '%');
        });
    }

    $tasks = $tasks->orderBy('status', 'asc')
                   ->orderBy('priority', 'desc')
                   ->orderBy('due_date', 'asc')
                   ->get();

    return view('welcome', compact('tasks'));
})->name('task.index');

Route::post('/post-task', [TaskController::class, 'store'])->name('task.store');
Route::get('/edit-task/{task}', [TaskController::class, 'edit'])->name('task.edit');
Route::put('/edit-task/{task}', [TaskController::class, 'update'])->name('task.edit');
Route::delete('/delete-task/{task}', [TaskController::class, 'destroy'])->name('task.delete');
