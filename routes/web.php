<?php

use App\Http\Controllers\PmsCommentController;
use App\Http\Controllers\PmsProjectController;
use App\Http\Controllers\PmsTaskController;
use App\Http\Controllers\PmsTeamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.home');
})->name('home');


Auth::routes();

// Project Crud
Route::get('projects', [PmsProjectController::class, 'index'])->name('projects.index');
Route::get('project/create', [PmsProjectController::class, 'create'])->name('project.create');
Route::post('projects', [PmsProjectController::class, 'store'])->name('project.store');
Route::get('projects/{id}/edit', [PmsProjectController::class, 'edit'])->name('project.edit');
Route::post('projects/{id}', [PmsProjectController::class, 'update'])->name('project.update');
Route::get('projects/{id}', [PmsProjectController::class, 'destroy'])->name('project.destroy');

//teams crud
Route::get('teams', [PmsTeamController::class, 'index'])->name('teams.index');
Route::get('teams/create', [PmsTeamController::class, 'create'])->name('teams.create');
Route::post('teams', [PmsTeamController::class, 'store'])->name('teams.store');
Route::get('teams/{id}/edit', [PmsTeamController::class, 'edit'])->name('teams.edit');
Route::put('teams/{id}', [PmsTeamController::class, 'update'])->name('teams.update');
Route::get('teams/{id}', [PmsTeamController::class, 'destroy'])->name('teams.destroy');

//task crud

Route::get('tasks/{id?}', [PmsTaskController::class, 'index'])->name('tasks.index');
Route::get('tasks/create', [PmsTaskController::class, 'create'])->name('tasks.create');
Route::post('tasks', [PmsTaskController::class, 'store'])->name('tasks.store');
Route::get('tasks/{id}/edit', [PmsTaskController::class, 'edit'])->name('tasks.edit');
Route::put('tasks/{id}', [PmsTaskController::class, 'update'])->name('tasks.update');
Route::delete('tasks/{id}', [PmsTaskController::class, 'destroy'])->name('tasks.destroy');

//comment crud
Route::get('comments', [PmsCommentController::class, 'index'])->name('comments.index');  // List all comments
Route::get('comments/create', [PmsCommentController::class, 'create'])->name('comments.create'); // Show create form
Route::post('comments', [PmsCommentController::class, 'store'])->name('comments.store'); // Store new comment
Route::get('comments/{id}/edit', [PmsCommentController::class, 'edit'])->name('comments.edit'); // Show edit form
Route::put('comments/{id}', [PmsCommentController::class, 'update'])->name('comments.update'); // Update comment
Route::delete('comments/{id}', [PmsCommentController::class, 'destroy'])->name('comments.destroy'); // Delete comment