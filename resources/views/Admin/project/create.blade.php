@extends('layouts.app')
@section('content')
    <form action="{{ route('postAddProject') }}" method="POST">
        @csrf
        <div class="card p-5 mt-5">
            <div class="card-body">
                <h1 class="text-center"> Add Project </h1>
                <label for="">Title</label>
                <input type="text" class="form-control" name="title">

                <label for="">Details</label>
                <input type="text" class="form-control" name="detail">

                <label for="">Git link</label>
                <input type="text" class="form-control" name="git_link">

                <label for="">Status</label>
                <input type="text" class="form-control" name="status">

                <button type="submit" class="btn btn-primary mt-3">ADD</button>
            </div>
        </div>
    </form>
@endsection
