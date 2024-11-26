<?php

use App\Http\Controllers\PmsCommentController;
use App\Http\Controllers\PmsProjectController;
use App\Http\Controllers\PmsTaskController;
use App\Http\Controllers\PmsTeamController;
use App\Models\PmsProject;
use App\Models\PmsTask;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Auth::routes();
// middleware for authentication
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        $projectCount = PmsProject::count();
        $userCount = User::count();
        $totalTask = PmsTask::where('user_id', Auth::user()->id)->count();
        $recentTasks = PmsTask::where('user_id', Auth::user()->id)->with('projects')->orderBy('created_at', 'desc')->get();
        if (Auth::user()->roles->first()->name == 'Admin') {
            $recentTasks = PmsTask::with('projects')->orderBy('created_at', 'desc')->get();
        }
        $pendingTask = PmsTask::where('user_id', Auth::user()->id)->where('status', 'Pending')->count();
        // $allProjectStatus = PmsTask::where('user_id', Auth::user()->id)->groupBy('status')->get();
        return view('admin.home', compact('projectCount', 'userCount', 'totalTask', 'pendingTask', 'recentTasks'));
    })->name('home');

    // Project Crud
    Route::get('projects', [PmsProjectController::class, 'index'])->name('projects.index');
    Route::get('project/create', [PmsProjectController::class, 'create'])->name('project.create')->middleware('role.notuser');
    Route::post('projects', [PmsProjectController::class, 'store'])->name('project.store');
    Route::get('projects/{id}/edit', [PmsProjectController::class, 'edit'])->name('project.edit');
    Route::post('projects/{id}', [PmsProjectController::class, 'update'])->name('project.update');
    Route::get('projects/{id}', [PmsProjectController::class, 'destroy'])->name('project.destroy');

    //teams crud
    Route::middleware('role.notuser')
        ->group(function () {
            Route::get('teams', [PmsTeamController::class, 'index'])->name('teams.index');
            Route::get('teams/create', [PmsTeamController::class, 'create'])->name('teams.create');
            Route::post('teams', [PmsTeamController::class, 'store'])->name('teams.store');
            Route::get('teams/{id}/edit', [PmsTeamController::class, 'edit'])->name('teams.edit');
            Route::put('teams/{id}', [PmsTeamController::class, 'update'])->name('teams.update');
            Route::get('teams/{id}', [PmsTeamController::class, 'destroy'])->name('teams.destroy');
        });

    //task crud
    Route::get('tasks/{id?}', [PmsTaskController::class, 'index'])->name('tasks.index');
    Route::get('create/tasks/{id?}', [PmsTaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks', [PmsTaskController::class, 'store'])->name('tasks.store');
    Route::get('tasks/{id}/edit', [PmsTaskController::class, 'edit'])->name('tasks.edit');
    Route::put('tasks/{id}', [PmsTaskController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/{id}', [PmsTaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/status/{id?}', [PmsTaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    //comment crud
    Route::get('comments', [PmsCommentController::class, 'index'])->name('comments.index');
    Route::get('comments/create', [PmsCommentController::class, 'create'])->name('comments.create');
    Route::post('comments', [PmsCommentController::class, 'store'])->name('comments.store');
    Route::get('comments/{id}/edit', [PmsCommentController::class, 'edit'])->name('comments.edit');
    Route::put('comments/{id}', [PmsCommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{id}', [PmsCommentController::class, 'destroy'])->name('comments.destroy');
});
