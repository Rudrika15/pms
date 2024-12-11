@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Team</h1>

        <form action="{{ route('teams.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="project_id " class="mb-2">Select Project:</label>
                <select name="project_id" class="form-select" id="">
                    <option value="" selected disabled>Select Project</option>
                    @foreach ($projects as $item)
                        <option value="{{ $item->id }}" @if (url()->previous() == route('tasks.create', $item->id)) selected @endif disabled>
                            {{ $item->title }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <span class="text-danger">Please Select Project</span>
                @enderror
            </div>
            <div class="mb-3">
                <div class="row">
                    @foreach ($users as $item)
                        <div class="col-md-2 pt-2">
                            <label for="{{ $item->id }}">
                                <input type="checkbox" id="{{ $item->id }}" class="" name="user_id[]"
                                    value="{{ $item->id }}">{{ explode(' ', $item->name)[0] }}</input>
                            </label>
                        </div>
                    @endforeach
                    @error('user_id')
                        <span class="text-danger">Please Select User</span>
                    @enderror
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Create Team</button>
        </form>
    </div>
@endsection
