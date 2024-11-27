@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Project</h1>

        <form action="{{ route('project.update', $project->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="" class="mt-3">Title</label>
                <input type="text" value="{{ $project->title }}" class="form-control mb-3 " name="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="">Details</label>
                <textarea class="form-control mb-3" name="detail"> {{ $project->detail }} </textarea>
                @error('detail')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="">Links</label>
                <textarea cols="30" rows="5" class="form-control mb-3" name="git_link"> {{ $project->git_link }} </textarea>
            </div>
            <div class="mb-3">
                <label for="">Status</label>
                <select name="status" class="form-control mb-3" id="">
                    <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="hold" {{ $project->status == 'hold' ? 'selected' : '' }}>Hold</option>
                    <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary ">EDIT</button>
        </form>
    </div>
@endsection
