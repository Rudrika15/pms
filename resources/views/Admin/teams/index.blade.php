@extends('layouts.app')

@section('content')
    <h1>Teams</h1>
    <a href="{{ route('teams.create') }}">Add New Team</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Project ID</th>
                <th>User ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teams as $team)
                <tr>
                    <td>{{ $team->id }}</td>
                    <td>{{ $team->project_id }}</td>
                    <td>{{ $team->user_id }}</td>
                    <td>
                        <a href="{{ route('teams.edit', $team->id) }}">Edit</a>
                        <form action="{{ route('teams.destroy', $team->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
