<?php

namespace App\Http\Controllers;

use App\Models\PmsProject;
use App\Models\PmsTask;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getTeamAndTaskCounts($projectId)
    {
        $project = PmsProject::find($projectId);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        $teamMembers = User::whereHas('tasks', function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })->get(['id', 'name']);

        $taskCounts = PmsTask::where('project_id', $projectId)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'projectTitle' => $project->title,
            'team' => $teamMembers,
            'taskCounts' => $taskCounts,
        ]);
    }
}
