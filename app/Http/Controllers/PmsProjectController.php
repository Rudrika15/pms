<?php

namespace App\Http\Controllers;

use App\Models\pmsProject;
use Illuminate\Http\Request;

class PmsProjectController extends Controller
{
    public function addProject()
    {
        return view('admin.project.create');
    }

    public function postAddProject(Request $request)
    {
        $pmsProject = new pmsProject();
        $pmsProject->title = $request->title;
        $pmsProject->detail = $request->detail;
        $pmsProject->git_link = $request->git_link;
        $pmsProject->status = $request->status;
        $pmsProject->save();

        return redirect()->back()->with('success', 'Projcet Added Successfully');
    }

    public function viewProject()
    {
        $project = pmsProject::all();
        return \view('admin.project.index', \compact('project'));
    }

    public function editProject($id)
    {
        $project = pmsProject::find($id);
        return view('admin.project.update', compact('project'));
    }

    public function postEditProject(Request $request, $id)
    {

        $pmsProject = PmsProject::findOrFail($id);

        $pmsProject->title = $request->title;
        $pmsProject->detail = $request->detail;
        $pmsProject->git_link = $request->git_link;
        $pmsProject->status = $request->status;

        $pmsProject->save();

        return redirect()->route('home')->with('success', 'Project Updated Successfully');
    }
    public function deleteProject($id)
    {
        // Find the project by its ID
        $pmsProject = PmsProject::findOrFail($id);

        // Delete the project
        $pmsProject->delete();

        // Redirect with success message
        return redirect()->back()->with('success', 'Project Deleted Successfully');
    }
}
