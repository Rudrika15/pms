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

        // Fetch team members along with their tasks' deadlines and statuses
        $teamMembers = User::whereHas('tasks', function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })
            ->with(['tasks' => function ($query) use ($projectId) {
                $query->where('project_id', $projectId)->select('user_id', 'status', 'deadline');
            }])
            ->get(['id', 'name']);

        // Fetch task counts grouped by status for each team member
        $taskCounts = PmsTask::where('project_id', $projectId)
            ->select('user_id', 'status', DB::raw('COUNT(*) as count'))
            ->groupBy('user_id', 'status')
            ->get();

        // Organize task counts by user
        $taskCountsByUser = [];
        foreach ($taskCounts as $task) {
            $userId = $task->user_id;
            if (!isset($taskCountsByUser[$userId])) {
                $taskCountsByUser[$userId] = ['todo' => 0, 'completed' => 0, 'deployed' => 0];
            }

            if ($task->status == 'to-do') {
                $taskCountsByUser[$userId]['todo'] = $task->count;
            } elseif ($task->status == 'completed') {
                $taskCountsByUser[$userId]['completed'] = $task->count;
            } elseif ($task->status == 'deployed') {
                $taskCountsByUser[$userId]['deployed'] = $task->count;
            }
        }

        // Format data for the response
        $teamWithTasks = $teamMembers->map(function ($member) use ($taskCountsByUser) {
            return [
                'name' => $member->name,
                'tasks' => $member->tasks->map(function ($task) {
                    return [
                        'status' => $task->status,
                        'deadline' => $task->deadline,
                    ];
                }),
                'taskCounts' => $taskCountsByUser[$member->id] ?? ['todo' => 0, 'completed' => 0, 'deployed' => 0],
            ];
        });

        return response()->json([
            'projectTitle' => $project->title,
            'team' => $teamWithTasks,
        ]);
    }
}
