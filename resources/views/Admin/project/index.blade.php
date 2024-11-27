@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1>Project List</h1>
            <a href="{{ route('project.create') }}" style="float: right" class="btn btn-sm btn-primary mb-3">Add Project</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Detail</th>
                <th>Git Link</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($project as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->detail }}</td>
                        <td>{{ $item->git_link }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <div class="d-flex mt-3 mb-3 gap-3">
                                <a href="{{ route('project.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('project.destroy', $item->id) }}"
                                    onclick="return confirm('Do you want to delete it ')"
                                    class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
