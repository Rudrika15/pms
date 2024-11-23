<?php

namespace App\Http\Controllers;

use App\Models\PmsTask;
use Illuminate\Http\Request;

class PmsTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = PmsTask::all();
        return view('admin.tasks.index', compact('tasks'));
    }

    // Show form to create a new task
    public function create()
    {
        return view('admin.tasks.create');
    }

    // Store a new task
    public function store(Request $request)
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

        $pmsTask = new PmsTask();
        $pmsTask->project_id = $request->project_id;  // Assign project_id
        $pmsTask->user_id = $request->user_id;        // Assign user_id
        $pmsTask->title = $request->title;            // Assign title
        $pmsTask->detail = $request->detail;          // Assign detail
        $pmsTask->status = $request->status;          // Assign status
        $pmsTask->priority = $request->priority;      // Assign priority
        $pmsTask->deadline = $request->deadline;      // Assign deadline

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $pmsTask->attachment = $request->file('attachment')->store('attachments');
        }

        $pmsTask->save(); // Save the new task

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
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
        $pmsTask->project_id = $request->project_id;  // Update project_id
        $pmsTask->user_id = $request->user_id;        // Update user_id
        $pmsTask->title = $request->title;            // Update title
        $pmsTask->detail = $request->detail;          // Update detail
        $pmsTask->status = $request->status;          // Update status
        $pmsTask->priority = $request->priority;      // Update priority
        $pmsTask->deadline = $request->deadline;      // Update deadline

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $pmsTask->attachment = $request->file('attachment')->store('attachments');
        }

        $pmsTask->save(); // Save the updated task

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // Delete a task
    public function destroy($id)
    {
        $task = PmsTask::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
