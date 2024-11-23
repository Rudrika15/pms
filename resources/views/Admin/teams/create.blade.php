@extends('layouts.app')

@section('content')
    <h1>Add New Team</h1>

    <form action="{{ route('teams.store') }}" method="POST">
        @csrf
        <div>
            <label for="project_id">Project ID:</label>
            <input type="number" id="project_id" name="project_id" required>
        </div>
        <div>
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" required>
        </div>
        <button type="submit">Create Team</button>
    </form>
@endsection
