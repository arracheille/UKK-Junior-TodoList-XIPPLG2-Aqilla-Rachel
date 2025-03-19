<?php

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $tasks = Task::query();

    // Filter berdasarkan status
    if ($request->filled('filter_status') && $request->filter_status !== 'all') {
        $tasks->where('status', $request->filter_status === 'done' ? 1 : 0);
    }

    // Filter berdasarkan prioritas
    if ($request->filled('filter_priority') && $request->filter_priority !== 'all') {
        $tasks->where('priority', $request->filter_priority);
    }

    // Filter berdasarkan tanggal
    if ($request->filled('filter_date')) {
        $tasks->whereDate('due_date', $request->filter_date);
    }

    // Ambil data yang sudah difilter
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
