@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Project</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('project.update', $project->id) }}" method="POST">
            @csrf

            <label for="" class="mt-3">Title</label>
            <input required type="text" value="{{ $project->title }}" class="form-control mb-3 " name="title">

            <label for="">Details</label>
            <textarea required class="form-control mb-3" name="detail"> {{ $project->detail }} </textarea>

            <label for="">Links</label>
            <textarea cols="30" rows="5" class="form-control mb-3" name="git_link"> {{ $project->git_link }} </textarea>

            <label for="">Status</label>
            <select name="status" class="form-control mb-3" id="">
                <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="hold" {{ $project->status == 'hold' ? 'selected' : '' }}>Hold</option>
                <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="btn btn-primary mt-3">EDIT</button>

        </form>
    </div>
@endsection
