<?php

namespace App\Http\Controllers;

use App\Models\PmsComment;
use Illuminate\Http\Request;

class PmsCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = PmsComment::all();
        return view('admin.comments.index', compact('comments'));
    }

    // Show form to create a new comment
    public function create()
    {
        return view('admin.comments.create');
    }

    // Store a new comment
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required|string|max:500',
        ]);

        $pmsComment = new PmsComment();
        $pmsComment->task_id = $request->task_id;  // Assign task_id
        $pmsComment->user_id = $request->user_id;  // Assign user_id
        $pmsComment->comment = $request->comment;  // Assign comment
        $pmsComment->save(); // Save the new comment

        return redirect()->route('comments.index')->with('success', 'Comment added successfully.');
    }

    // Show form to edit a comment
    public function edit($id)
    {
        $comment = PmsComment::findOrFail($id);
        return view('admin.comments.edit', compact('comment'));
    }

    // Update an existing comment
    public function update(Request $request, $id)
    {
        $request->validate([
            'task_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required|string|max:500',
        ]);

        $pmsComment = PmsComment::findOrFail($id);
        $pmsComment->task_id = $request->task_id;  // Update task_id
        $pmsComment->user_id = $request->user_id;  // Update user_id
        $pmsComment->comment = $request->comment;  // Update comment
        $pmsComment->save(); // Save the updated comment

        return redirect()->route('comments.index')->with('success', 'Comment updated successfully.');
    }

    // Delete a comment
    public function destroy($id)
    {
        $comment = PmsComment::findOrFail($id);
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully.');
    }
}
