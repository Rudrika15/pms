@extends('layouts.app')

<form action="{{ route('postEditProject', $project->id) }}" method="POST">
    @csrf
    <div class="card p-5 mt-5">
        <div class="card-body">
            <h1 class="text-center"> Edit Project </h1>
            <label for="">Title</label>
            <input type="text" value="{{ $project->title }}" class="form-control" name="title">

            <label for="">Details</label>
            <input type="text" value="{{ $project->detail }}" class="form-control" name="detail">

            <label for="">Git link</label>
            <input type="text" value="{{ $project->git_link }}" class="form-control" name="git_link">

            <label for="">Status</label>
            <input type="text" value="{{ $project->status }}" class="form-control" name="status">

            <button type="submit" class="btn btn-primary mt-3">EDIT</button>
        </div>
    </div>
</form>
