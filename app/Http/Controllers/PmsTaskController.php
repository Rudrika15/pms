<?php

namespace App\Http\Controllers;

use App\Mail\TaskCreated;
use App\Models\PmsTask;
use App\Models\PmsTeam;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PmsTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($projectId,)
    {
        $id =  $projectId;
        $statuses = ['to-do', 'in-progress', 'done', 'deployed', 'completed'];
        // if (Auth::user()->roles->first()->name == 'User') {
        //     $tasksByStatus = collect($statuses)
        //         ->mapWithKeys(fn($status) => [$status => collect()])
        //         ->merge(
        //             pmsTask::where('project_id', $projectId)
        //                 ->whereIn('status', $statuses)
        //                 ->where('user_id', Auth::user()->id)
        //                 ->with('comment')
        //                 ->get()
        //                 ->groupBy('status')
        //         );
        // } else {
        $tasksByStatus = collect($statuses)
            ->mapWithKeys(fn($status) => [$status => collect()])
            ->merge(
                pmsTask::where('project_id', $projectId)
                    ->whereIn('status', $statuses)
                    ->with('comment')
                    ->get()
                    ->groupBy('status')
            );
        // }

        return view('admin.tasks.index', compact('tasksByStatus', 'id', 'statuses'));
    }

    // Show form to create a new task
    public function create($projectId)
    {
        $teamMember = PmsTeam::where('project_id', $projectId)->with('user')->get();
        return view('admin.tasks.create', compact('teamMember'));
    }

    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'user_id' => 'required',
            'title' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
        ]);

        $pmsTask = new PmsTask();
        $pmsTask->project_id = $request->project_id;
        $pmsTask->user_id = $request->user_id;
        $pmsTask->title = $request->title;
        $pmsTask->detail = $request->detail ?? '';
        $pmsTask->status = 'to-do';
        $pmsTask->priority = $request->priority ?? 'low';
        $pmsTask->deadline = $request->deadline ?? Carbon::now();
        if ($request->hasFile('attachment')) {
            $pmsTask->attachment = $request->file('attachment')->store('attachments');
        }

        $pmsTask->save();

        $user = User::find($request->user_id);

        if ($user) {
            Mail::to($user->email)->send(new TaskCreated($pmsTask));
        } else {
            return redirect()->route('tasks.index', $request->project_id)->with('error', 'User not found!');
        }
        return redirect()->route('tasks.index', $request->project_id)->with('success', 'Task created successfully.');
    }

    // Show form to edit a task
    public function edit($id)
    {
        $task = PmsTask::findOrFail($id);
        return view('admin.tasks.edit', compact('task'));
    }

    // Update an existing task
    public function update(Request $request, $id)
    {
        $request->validate([
            'project_id' => 'required',
            'user_id' => 'required',
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx',
            'deadline' => 'required|date',
        ]);

        $pmsTask = PmsTask::findOrFail($id);
        $pmsTask->project_id = $request->project_id;
        $pmsTask->user_id = $request->user_id;
        $pmsTask->title = $request->title;
        $pmsTask->detail = $request->detail;
        $pmsTask->status = $request->status;
        $pmsTask->priority = $request->priority;
        $pmsTask->deadline = $request->deadline;

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $pmsTask->attachment = $request->file('attachment')->store('attachments');
        }

        $pmsTask->save(); // Save the updated task

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    //update task status
    public function updateStatus(Request $request, $taskId)
    {
        $task = pmsTask::findOrFail($taskId);
        $task->status = $request->status; // Update status
        $task->save();

        return response()->json(['success' => true, 'message' => 'Task status updated successfully.']);
    }


    // Delete a task
    public function destroy($id)
    {
        $task = PmsTask::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
