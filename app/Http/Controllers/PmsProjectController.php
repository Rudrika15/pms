<?php

namespace App\Http\Controllers;

use App\Models\PmsProject;
use Illuminate\Http\Request;

class PmsProjectController extends Controller
{
    public function create()
    {
        return view('admin.project.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'detail' => 'required|string',
        ]);

        $PmsProject = new PmsProject();
        $PmsProject->title = $request->title;
        $PmsProject->detail = $request->detail;
        $PmsProject->git_link = $request->git_link;
        $PmsProject->status = "active";
        $PmsProject->save();

        return redirect()->route('tasks.index', $PmsProject->id)->with('success', 'Projcet Added Successfully');
    }

    public function index()
    {
        $project = PmsProject::orderBy('id', 'desc')->get();
        return \view('admin.project.index', \compact('project'));
    }

    public function edit($id)
    {
        $project = PmsProject::find($id);
        return view('admin.project.update', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'detail' => 'required|string',
        ]);

        $PmsProject = PmsProject::findOrFail($id);

        $PmsProject->title = $request->title;
        $PmsProject->detail = $request->detail;
        $PmsProject->git_link = $request->git_link;
        $PmsProject->status = $request->status;

        $PmsProject->save();

        return redirect()->route('projects.index')->with('success', 'Project Updated Successfully');
    }
    public function destroy($id)
    {
        // Find the project by its ID
        $PmsProject = PmsProject::findOrFail($id);

        // Delete the project
        $PmsProject->delete();

        // Redirect with success message
        return redirect()->back()->with('success', 'Project Deleted Successfully');
    }
}
