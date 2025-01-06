@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Add Project</h1>

        <form action="{{ route('project.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Title</label>
                <input type="text" value="{{ old('title') }}" class="form-control" name="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="">Details</label>
                <textarea cols="30" rows="5" class="form-control summernote" name="detail">{{ old('detail') }}</textarea>
                @error('detail')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="">Links</label>
                <textarea cols="30" rows="5" class="form-control summernote" name="git_link">{{ old('git_link') }}</textarea>
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
