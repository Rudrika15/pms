@extends('layouts.app')

@section('content')
    <form action="{{ route('project.update', $project->id) }}" method="POST">
        @csrf
        <div class="card p-5 mt-5">
            <div class="card-body">
                <h1 class="text-center"> Edit Project </h1>
                <label for="">Title</label>
                <input required type="text" value="{{ $project->title }}" class="form-control" name="title">

                <label for="">Details</label>
                <textarea required value="{{ $project->detail }}" class="form-control" name="detail"> </textarea>

                <label for="">Links</label>
                <textarea required value="{{ $project->git_link }}" cols="30" rows="5" class="form-control" name="git_link"> </textarea>

                <label for="">Status</label>
                <input required type="text" value="{{ $project->status }}" class="form-control" name="status">

                <button type="submit" class="btn btn-primary mt-3">EDIT</button>
            </div>
        </div>
    </form>
@endsection
