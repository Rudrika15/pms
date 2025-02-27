@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Add Task</h1>

        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="project_id" value="{{ request('id') }}">
            @if (illuminate\Support\Facades\Auth::user()->roles->first()->name == 'User')
                <input type="hidden" value="{{ illuminate\Support\Facades\Auth::user()->id }}" name="user_id">
            @else
                <div class="mb-3">
                    @if (count($teamMember) == 0)
                        <span>No member found, click here to create team --> </span>
                        <a href="{{ route('teams.create') }}" class="btn btn-primary">
                            create team
                        </a>
                    @else
                        <label for="user_id" class="form-label">User</label>


                        <select name="user_id" class="form-control user_id">
                            <option value="" disabled selected> Select Team member</option>
                            @foreach ($teamMember as $member)
                                <option value="{{ $member->user_id }}"
                                    {{ old('user_id') == $member->user_id ? 'selected' : '' }}>{{ $member->user->name }}
                                </option>
                            @endforeach

                        </select>
                    @endif

                    @error('user_id')
                        <span class="text-danger">Please Select User</span>
                    @enderror
                </div>
            @endif

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" value="{{ old('title') }}" class="form-control" id="title" name="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Detail</label>
                <textarea class="form-control" id="detail" name="detail" rows="4">{{ old('detail') }}</textarea>
                @error('detail')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" id="status">
                    <option value="to-do">TO DO</option>
                    <option value="in-progress">IN PROGRESS</option>
                    <option value="done">DONE</option>
                    <option value="deployed">DEPLOYED</option>
                    <option value="completed">COMPLETED</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div> --}}
            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-control" id="priority" name="priority">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment</label>
                <input type="file" class="form-control bg-white" id="attachment" name="attachment">
                @error('attachment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" id="deadline"
                    value="{{ \Carbon\Carbon::today()->toDateString() }}" name="deadline">
                @error('deadline')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
    </div>
    <script>
        var $jq = jQuery.noConflict();
        $jq(document).ready(function() {
            // Initialize Select2 on the select element with class "user_id"
            $jq('.user_id').select2({
                placeholder: "Select Team Member", // Optional placeholder text
                allowClear: true // Optional clear button
            });
        });
    </script>
@endsection
