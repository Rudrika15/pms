@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Add Project</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('project.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Title</label>
                <input required type="text" class="form-control" name="title">
            </div>
            <div class="mb-3">
                <label for="">Details</label>
                <textarea cols="30" rows="5" required class="form-control summernote" name="detail"></textarea>
            </div>

            <div class="mb-3">
                <label for="">Links</label>
                <textarea cols="30" rows="5" class="form-control summernote" name="git_link"></textarea>
            </div>

            {{-- <div class="mb-3">
                <label for="">Status</label>
               <select name="status" class="form-control" id="">
                   <option value="active">Active</option>
                   <option value="inactive">Completed</option>
               </select>
            </div> --}}

            <button type="submit" class="btn btn-primary mt-3">ADD</button>

        </form>
    </div>

@endsection
