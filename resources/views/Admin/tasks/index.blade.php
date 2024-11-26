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
            background: #5b5d5c;
            border-radius: 10px;
            color: white;
            box-shadow: -1px 7px 20px 0px #d3d3d3;
        }

        .left-col {
            height: 100%;
        }

        .right-col {
            height: 550px;
        }

        .sticky-form {
            position: sticky;
            bottom: 0;
            /* Add background to cover any content behind it */
            padding: 10px 0;
            z-index: 10;
            /* Ensure the form stays above other content */
        }

        .comments {
            max-height: 450px;
            overflow-y: scroll;
        }

        .comments::-webkit-scrollbar {
            width: 5px;
            color: orangered;
            scroll-behavior: smooth;
        }

        .comments::-webkit-scrollbar-thumb {
            background-color: #f46613;
            border-radius: 10px;
        }

        .comments::-webkit-scrollbar-thumb:hover {
            background-color: darkred;
        }

        .comments::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 10px;
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
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="kanban-board gap-3">
            @foreach ($tasksByStatus as $status => $tasks)
                <div class="kanban-column" id="{{ $status }}">
                    <h2>{{ ucfirst($status) }}</h2>
                    @if ($tasks->isEmpty())
                        <p>No tasks available.</p>
                    @else
                        @foreach ($tasks as $item)
                            <div class="kanban-card" id="status" draggable="true">
                                <!-- Task title links to its unique modal -->
                                <a href="#" class="kanban-card-title text-decoration-none text-dark"
                                    data-bs-toggle="modal" data-bs-target="#modal-{{ $item->id }}"
                                    data-task-id="{{ $item->id }}">
                                    {{ $item->title }}
                                </a>
                                <select class="form-select status mt-2" name="status" data-task-id="{{ $item->id }}">
                                    @foreach ($statuses as $dropdownStatus)
                                        <option value="{{ $dropdownStatus }}"
                                            {{ $item->status === $dropdownStatus ? 'selected' : '' }}>
                                            {{ ucfirst($dropdownStatus) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Modal for each task -->
                            <div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1"
                                aria-labelledby="modalLabel-{{ $item->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" aria-hidden="true">
                                <div class="modal-dialog modal-lg">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title" id="modalLabel-{{ $item->id }}">
                                                {{ $item->title }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-8 left-col">

                                                    <p>{{ $item->detail }}</p>
                                                    Assigned To : {{ $item->user->name ?? '' }}

                                                </div>
                                                <div class="col-md-4 right-col">
                                                    <div class="comments">
                                                        @if ($item->comment && count($item->comment) > 0)
                                                            @foreach ($item->comment as $comment)
                                                                <p>{{ $comment->comment }}</p>
                                                                <p>{{ $comment->user->name ?? '' }}</p>
                                                                <hr>
                                                            @endforeach
                                                        @else
                                                            <p>No comments available for this task.</p>
                                                            <hr>
                                                        @endif
                                                    </div>
                                                    <!-- Sticky Comment Form -->
                                                    <div class="text-box sticky-form">
                                                        <form action="{{ route('comments.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="task_id"
                                                                value="{{ $item->id }}">
                                                            <div class="mb-3">

                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Enter Comment"
                                                                        aria-label="Enter Comment"
                                                                        aria-describedby="button-addon2">
                                                                    <button class="btn btn-primary" type="button"
                                                                        id="button-addon2">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach





        </div>
    </div>

    {{-- <div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $item->id }}"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel-{{ $item->id }}">{{ $item->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add task details here -->
                    <p>{{ $item->detail }}</p>
                    <!-- You can include more details about the task -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- Add more action buttons!-->
                </div>
            </div>
        </div>
    </div> --}}
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
