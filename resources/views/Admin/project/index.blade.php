@extends('layouts.app')

<div class="container p-5">
    <a href="{{ route('addProject') }}" class="btn btn-primary " style="float: right">Add new</a>
    <div class="table">
        <table class="table-bordered">
            <thead>
                <th>Id</th>
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
                                <a href="{{ route('editProject', $item->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('deleteProject', $item->id) }}"
                                    onclick="return confirm('Do you want to delete it ')"
                                    class="btn btn-danger">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
