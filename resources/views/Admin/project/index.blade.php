@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-format-list-bulleted-square"></i>
                </span> Project List
            </h3>
            @if (Auth::user()->roles[0]->name != 'User')
                <a href="{{ route('project.create') }}" style="float: right" class="btn btn-sm btn-primary mb-3">Add
                    Project</a>
            @endif
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Title</th>
                            <th>Detail</th>
                            <th>Links</th>
                            <th>Status</th>
                            @if (Auth::user()->roles[0]->name != 'User')
                                <th>Action</th>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($project as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td class="text-wrap">{{ $item->detail }}</td>
                                    <td class="text-wrap">{{ $item->git_link }}</td>
                                    <td>{{ $item->status }}</td>
                                    @if (Auth::user()->roles[0]->name != 'User')
                                        <td>
                                            <div class="d-flex mt-3 mb-3 gap-2">
                                                <a href="{{ route('project.edit', $item->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>

                                                <a href="{{ route('project.destroy', $item->id) }}"
                                                    data-url= "{{ route('project.destroy', $item->id) }}"
                                                    class="btn btn-sm btn-dark delete-button">Delete</a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
