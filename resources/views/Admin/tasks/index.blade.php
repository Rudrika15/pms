@extends('layouts.app')

@section('content')
    <style>
        .kanban-board {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
        }

        .kanban-column {
            background-color: #fff;
            border-radius: 8px;
            width: 40%;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-height: 300px;

        }

        .kanban-column h2 {
            text-align: center;
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .kanban-card {
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 5px;
            margin: 10px 0;
            padding: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .kanban-card:hover {
            background-color: #f0f0f0;
        }

        .kanban-card:active {
            background-color: #ddd;
        }

        .kanban-column:hover {
            background-color: #f9f9f9;
        }

        h2 {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: -webkit-sticky;
            /* Safari */
            background: #E5E5E5;
            box-shadow: -1px 7px 20px 0px #d3d3d3;
        }
    </style>
    <div class="container">
        <div class="d-flex  justify-content-between">
            <h1>Task List</h1>
            <a href="{{ route('tasks.create', $id) }}" class="btn btn-sm mb-4 btn-primary">
                <span>
                    <i class="fa fa-plus"></i>
                    Add New Task
                </span>
            </a>
        </div>
        {{-- <a href="{{ route('tasks.create') }}" style="float: right" class="btn btn-primary mb-3">Add Task</a> --}}

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="kanban-board gap-3">
            <!-- To Do Column -->
            <div class="kanban-column " id="todo">
                <h2>To Do</h2>
                @foreach ($toDo as $item)
                    <div class="kanban-card" draggable="true" data-task-id="{{ $item->id }}">{{ $item->title }}
                        <select class="form-select status mt-2" class="status" name="status"
                            data-task-id="{{ $item->id }}">
                            <option value="to-do" selected disabled> To Do</option>
                            <option value="in-progress">In Progress</option>
                            <option value="done">Done</option>
                            <option value="deployed">Deploy</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                @endforeach

            </div>
            <!-- In Progress Column -->
            <div class="kanban-column" id="inprogress">
                <h2>In Progress</h2>
                @foreach ($inProgress as $item)
                    <div class="kanban-card" id="status" draggable="true">{{ $item->title }}

                        <select class="form-select status mt-2" class="status" name="status"
                            data-task-id="{{ $item->id }}">
                            <option value="in-progress" selected disabled>In Progress</option>
                            <option value="to-do"> To Do</option>
                            <option value="done">Done</option>
                            <option value="deployed">Deploy</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                @endforeach
            </div>
            <div class="kanban-column" id="done">
                <h2>Done</h2>
                @foreach ($done as $item)
                    <div class="kanban-card" id="status" draggable="true">{{ $item->title }}
                        <select class="form-select status mt-2" class="status" name="status"
                            data-task-id="{{ $item->id }}">
                            <option value="done" selected disabled>Done</option>
                            <option value="to-do"> To Do</option>
                            <option value="in-progress">In Progress</option>
                            <option value="deployed">Deploy</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                @endforeach
            </div>
            <div class="kanban-column" id="deploy">
                <h2>Deploy</h2>
                @foreach ($deployed as $item)
                    <div class="kanban-card" id="status" draggable="true">{{ $item->title }}
                        <select class="form-select status mt-2" class="status" name="status"
                            data-task-id="{{ $item->id }}">
                            <option value="deployed" selected disabled>Deploy</option>
                            <option value="to-do"> To Do</option>
                            <option value="in-progress">In Progress</option>
                            <option value="done">Done</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                @endforeach
            </div>
            <div class="kanban-column" id="completed">
                <h2>Completed</h2>
                @foreach ($completed as $item)
                    <div class="kanban-card" id="status" draggable="true">{{ $item->title }}
                        <select class="form-select status mt-2" name="status" data-task-id="{{ $item->id }}">
                            <option value="completed" selected disabled>Completed</option>
                            <option value="to-do"> To Do</option>
                            <option value="in-progress">In Progress</option>
                            <option value="done">Done</option>
                            <option value="deployed">Deploy</option>
                        </select>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Completed Column -->
    <script>
        $(document).ready(function() {
            // Delegate the change event to all status dropdowns
            $('.kanban-board').on('change', '.status', function() {
                var status = $(this).val();
                var taskId = $(this).data('task-id'); // Retrieve task ID from the 'data-task-id' attribute

                // Send the updated status via AJAX
                $.ajax({
                    url: "{{ route('tasks.updateStatus', ':taskId') }}".replace(':taskId', taskId),
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        taskId: taskId, // Include the taskId in the data
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to update status.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while updating the status.');
                    }
                });
            });
        });
    </script>
    {{-- <script>
        // Adding drag-and-drop functionality
        const cards = document.querySelectorAll('.kanban-card');
        const columns = document.querySelectorAll('.kanban-column');

        cards.forEach(card => {
            card.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text', e.target.id);
            });
        });

        columns.forEach(column => {
            column.addEventListener('dragover', (e) => {
                e.preventDefault();
            });

            column.addEventListener('drop', (e) => {
                e.preventDefault();
                const cardId = e.dataTransfer.getData('text');
                const card = document.getElementById(cardId);
                column.appendChild(card);
            });
        });
    </script> --}}
@endsection
