@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-pencil"></i>
                </span> Edit Task
            </h3>
            {{-- @if (Auth::user()->roles[0]->name != 'User')
                <a href="{{ route('project.create') }}" style="float: right" class="btn btn-sm btn-primary mb-3">Add
                    Project</a>
            @endif --}}
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project</label>
                        <input type="text" class="form-control" id="project_id" name="project_name"
                            value="{{ $task->projects->title }}" readonly>
                        <input type="hidden" name="project_id" value="{{ $task->project_id }}" id="">

                        {{-- <select name="project_id" class="form-select" readonly id="">
                            <option value=""></option>
                        </select> --}}
                        @error('project_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        {{-- <input type="number" class="form-control" id="user_id" name="user_id"
                            value="{{ $task->user_id }}"> --}}
                        <select name="user_id" class="form-select" id="">
                            @foreach ($project_user as $item)
                                @foreach ($item['users'] as $user)
                                    <option value="{{ $item->id }}" {{ $task->user_id == $item->id ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $task->title }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail</label>
                        <textarea class="form-control" id="detail" name="detail" rows="4">{{ $task->detail }}</textarea>
                        @error('detail')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status" name="status"
                            value="{{ $task->status }}">
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-control" id="priority" name="priority">
                            <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {{-- show image like thumbnail --}}
                        @if ($task->attachment)
                            <img src="{{ asset($task->attachment) }}" alt="" width="100" height="100"
                                class="img-thumbnail mb-3" id="preview">
                        @else
                            <img src="" alt="" width="100" height="100" class="d-none img-thumbnail mb-3"
                                id="preview">
                        @endif
                        <br>
                        <label for="attachment" class="form-label">Attachment</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
                        {{-- @if ($task->attachment)
                            <small>Current file: {{ $task->attachment }}</small>
                        @endif --}}
                        @error('attachment')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline"
                            value="{{ $task->deadline }}">
                        @error('deadline')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </form>
            </div>
        </div>

    </div>
    <script>
        $('#attachment').change(function() {
            const file = $(this)[0].files[0];
            const fileReader = new FileReader();
            fileReader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#preview').removeClass('d-none');
            };
            fileReader.readAsDataURL(file);
        });
    </script>
@endsection
