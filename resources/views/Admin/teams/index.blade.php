@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1>Team List</h1>
            @if (Auth::user()->role != 'user')
                <a href="{{ route('teams.create') }}" class="btn btn-sm btn-primary mb-3 " style="float: right">Add Team</a>
            @endif
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project Name</th>
                    <th>User Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $team->title }}</td>
                        <td>
                            @foreach ($team->teams as $item)
                                <span class="bg-primary p-2 rounded-pill text-white">
                                    {{ explode(' ', $item->user->name)[0] }} &nbsp;
                                    @if (Auth::user()->roles[0]->name != 'User')
                                        <a href="javascript:void(0);" data-url="{{ route('teams.destroy', $item->id) }}"
                                            class="text-light text-decoration-none delete-button">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @endif
                                </span>
                                &nbsp;
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
