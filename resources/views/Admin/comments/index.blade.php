@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Comments List</h1>
        <a href="{{ route('comments.create') }}" style="float: right" class="btn btn-primary mb-3">Add Comment</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Task ID</th>
                    <th>User ID</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $comment->task_id }}</td>
                        <td>{{ $comment->user_id }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>
                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
