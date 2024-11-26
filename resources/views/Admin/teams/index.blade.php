@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1>Team List</h1>
            @if (Auth::user()->role != 'user')
                <a href="{{ route('teams.create') }}" class="btn btn-primary mb-3 " style="float: right">Add Team</a>
            @endif
        </div>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project Name</th>
                    <th>User Name</th>
                    {{-- <th>Actions</th> --}}
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
                                    {{ $item->user->name }} &nbsp;
                                    @if (Auth::user()->roles[0]->name != 'User')
                                        <a href="{{ route('teams.destroy', $item->id) }}"
                                            onclick="return confirm('Do you want to delete it ')"
                                            class="text-light text-decoration-none">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @endif
                                </span>
                                &nbsp;
                            @endforeach
                        </td>

                        {{-- @foreach ($team->project as $item)
                            <td>
                                @if ($projectid == $team->project_id)
                                    {{ $team->user->name }}
                                @endif
                            </td>
                        @endforeach --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection
