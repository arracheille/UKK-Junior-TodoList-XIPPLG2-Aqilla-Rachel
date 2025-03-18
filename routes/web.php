<?php

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tasks = Task::orderBy('status', 'asc')
                 ->orderBy('priority', 'desc')
                 ->orderBy('due_date', 'asc')
                 ->get();
    return view('welcome', compact('tasks'));
})->name('task.index');

Route::post('/post-task', [TaskController::class, 'store'])->name('task.store');
Route::get('/edit-task/{task}', [TaskController::class, 'edit'])->name('task.edit');
Route::put('/edit-task/{task}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/delete-task/{task}', [TaskController::class, 'destroy'])->name('task.delete');
