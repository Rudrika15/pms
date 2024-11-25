<?php

namespace App\Http\Controllers;

use App\Models\pmsProject;
use App\Models\pmsTeam;
use App\Models\User;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class PmsTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = PmsProject::with(['teams.user'])->get();
        return view('admin.teams.index', compact('teams'));
    }

    // Show the form to create a new team
    public function create()
    {
        $projects = pmsProject::all();
        $users = User::all();
        return view('admin.teams.create', compact('users', 'projects'));
    }

    // Store a new team
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'user_id' => 'required',
        ]);
        $users = $request->user_id;
        foreach ($users as $user) {
            $pmsteams = new pmsTeam();
            $pmsteams->project_id = $request->project_id; // Set project_id
            $pmsteams->user_id = $user;       // Set user_id
            $pmsteams->save();
        }

        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }

    // Show the form to edit an existing team
    public function edit($id)
    {
        $team = pmsTeam::findOrFail($id);
        return view('admin.teams.edit', compact('team'));
    }

    // Update an existing team
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'project_id' => 'required|exists:projects,id',
        //     'user_id' => 'required|exists:users,id',
        // ]);

        $pmsteams = pmsTeam::findOrFail($id);
        $pmsteams->project_id = $request->project_id; // Assign updated project_id
        $pmsteams->user_id = $request->user_id;       // Assign updated user_id
        $pmsteams->save();


        return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
    }

    // Delete a team
    public function destroy($id)
    {
        $team = pmsTeam::findOrFail($id);
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully.');
    }
}
