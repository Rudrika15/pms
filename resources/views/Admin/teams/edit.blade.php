@extends('layouts.app')

@section('content')
    <h1>Edit Team</h1>

    <form action="{{ route('teams.update', $team->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="project_id">Project ID:</label>
            <input type="number" id="project_id" name="project_id" value="{{ $team->project_id }}" required>
        </div>
        <div>
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" value="{{ $team->user_id }}" required>
        </div>
        <button type="submit">Update Team</button>
    </form>
@endsection
