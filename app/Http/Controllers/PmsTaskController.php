<?php

namespace App\Http\Controllers;

use App\Models\PmsTask;
use App\Models\PmsTeam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PmsTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($projectId,)
    {
        $id =  $projectId;
        $toDo = pmsTask::where('project_id', $projectId)
            ->where('status', 'to-do')
            ->get();
        $inProgress = pmsTask::where('project_id', $projectId)
            ->where('status', 'in-progress')
            ->get();
        $done = pmsTask::where('project_id', $projectId)
            ->where('status', 'done')
            ->get();
        $deployed = pmsTask::where('project_id', $projectId)
            ->where('status', 'deployed')
            ->get();
        $completed = pmsTask::where('project_id', $projectId)
            ->where('status', 'completed')
            ->get();
        return view('admin.tasks.index', compact('toDo', 'inProgress', 'done', 'deployed', 'completed', 'id'));
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
            'deadline' => 'date',
        ]);

        $pmsTask = new PmsTask();
        $pmsTask->project_id = $request->project_id;
        $pmsTask->user_id = $request->user_id;
        $pmsTask->title = $request->title;
        $pmsTask->detail = $request->detail ?? '';
        $pmsTask->status = $request->status ?? 'to-do';
        $pmsTask->priority = $request->priority ?? 'low';
        $pmsTask->deadline = $request->deadline ?? Carbon::now();

        if ($request->hasFile('attachment')) {
            $pmsTask->attachment = $request->file('attachment')->store('attachments');
        }

        $pmsTask->save();

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
