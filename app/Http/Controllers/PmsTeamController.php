<?php

namespace App\Http\Controllers;

use App\Models\PmsProject;
use App\Models\PmsTask;
use App\Models\PmsTeam;
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

        $project_id = PmsTeam::all();
        $projects = PmsProject::where('status', 'active')
            ->whereNotIn('id', $project_id->pluck('project_id'))
            ->get();
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

        $pmsteams = PmsTeam::where('project_id', $request->project_id)->delete();

        $users = $request->user_id;
        foreach ($users as $user) {
            $pmsteams = new PmsTeam();
            $pmsteams->project_id = $request->project_id; // Set project_id
            $pmsteams->user_id = $user;       // Set user_id
            $pmsteams->save();
        }
        if (url()->previous() === route('teams.edit', ['id' => $request->project_id])) {
            return redirect()->route('teams.index')->with('success', 'Team edited successfully.');
        } else {
            return redirect()->route('teams.index')->with('success', 'Team created successfully.');
        }
    }
    // Show the form to edit an existing team
    public function edit($id)
    {
        $project = PmsProject::where('id', $id)
            ->with('teams.user')
            ->get();
        $allUsers = User::all();
        return view('admin.teams.edit', compact('project', 'allUsers'));
    }

    // Update an existing team
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'project_id' => 'required|exists:projects,id',
        //     'user_id' => 'required|exists:users,id',
        // ]);

        $pmsteams = PmsTeam::findOrFail($id);
        $pmsteams->project_id = $request->project_id; // Assign updated project_id
        $pmsteams->user_id = $request->user_id;       // Assign updated user_id
        $pmsteams->save();


        return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
    }

    // Delete a team
    public function destroy($id)
    {
        $team = PmsTeam::findOrFail($id);
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'User deleted successfully.');
    }
}
