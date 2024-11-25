@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Team</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teams.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="project_id " class="mb-2">Select Project:</label>
                <select name="project_id" class="form-select" id="" required>
                    <option value="" selected disabled>Select Project</option>
                    @foreach ($projects as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <div class="row">
                    @foreach ($users as $item)
                        <div class="col-md-2 pt-2">
                            <label for="{{ $item->id }}">
                                <input type="checkbox" id="{{ $item->id }}" class="" name="user_id[]"
                                    value="{{ $item->id }}">{{ $item->name }}</input>
                            </label>
                        </div>
                    @endforeach
                </div>

            </div>
            <button class="btn btn-primary" type="submit">Create Team</button>
        </form>
    </div>
@endsection
