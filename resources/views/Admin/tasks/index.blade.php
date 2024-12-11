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
            /* border: #878887 solid 2px; */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);


        }

        .kanban-column .h2 {
            text-align: center;
            margin-bottom: 20px;
            background-color: white;
        }

        .kanban-card {
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 5px;
            margin: 10px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 10px;
        }

        /* .kanban-card:hover {
                                                                                    background-color: #f0f0f0;
                                                                                }

                                                                                .kanban-card:active {
                                                                                    background-color: #ddd;
                                                                                } */

        /* .kanban-column:hover {
                                                                                background-color: #f9f9f9;
                                                                            } */

        .content {
            padding: 10px;
            min-height: 50vh;
            max-height: 65vh;
            overflow-y: scroll;
            position: relative;
            margin-top: 30px;
        }

        .content::-webkit-scrollbar {
            border-radius: 10px;
            width: 4px;
            margin-top: 10px;
            scroll-behavior: smooth;
        }

        .content::-webkit-scrollbar-thumb {
            background-color: #ff6600;
            border-radius: 5px;
            margin-top: 15px;

        }

        .h2 {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: white;
            height: 20px;
            margin: 0;
            padding: 0;
            border-radius: 10px;
        }

        .h2 h2 {
            padding: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            height: 50px;
            border-bottom: 2px solid #878887;
        }

        .left-col {
            height: 100%;
        }

        .right-col {
            height: 550px;
        }

        .sticky-form {
            position: fixed;
            padding: 10px;
            width: 28%;
            bottom: 10px;
        }

        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background-color: rgba(255, 255, 255, 0.1); */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 200px;
            animation: rotateClockwise 2.5s linear infinite;
            transform-origin: center;
            transform-box: fill-box;
        }

        .loader_circle_1 {
            animation: rotateClockwise 1.5s linear infinite;
            transform-origin: center;
            transform-box: fill-box;
        }

        @keyframes rotateClockwise {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes rotateCounterClockwise {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(-360deg);
            }
        }
    </style>
    <div class="container mb-5">
        {{-- new form for search task by id  --}}
        <div class="">
            <form action="{{ route('tasks.details') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search by Task ID">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- <div class="d-flex  justify-content-between">
            <h1>Task List</h1>
            <a href="{{ route('tasks.create', $id) }}" class="btn btn-sm mb-4 btn-primary">
                <span>
                    <i class="fa fa-plus"></i>
                    Add New Task
                </span>
            </a>
        </div> --}}
        {{-- <a href="{{ route('tasks.create') }}" style="float: right" class="btn btn-primary mb-3">Add Task</a> --}}

        <div class="kanban-board gap-3 ">
            @foreach ($tasksByStatus as $status => $tasks)
                <div class="kanban-column" id="{{ $status }}">
                    <div class="h2 w-100 ">
                        <h2 class="d-flex justify-content-between align-items-center">{{ ucfirst($status) }}
                            @if ($status == 'to-do')
                                <a href="{{ route('tasks.create', $id) }}" class="text-dark" style="float: right">
                                    <i class="fa fa-plus"></i>
                                </a>
                            @endif
                        </h2>

                    </div>
                    @if ($tasks->isEmpty())
                        <p class="mt-5 p-5">No tasks available.</p>
                    @else
                        <div class="content">
                            @foreach ($tasks as $item)
                                <div class="kanban-card" id="status" draggable="true">
                                    <!-- Task title links to its unique modal -->
                                    {{-- <a href="#" class="kanban-card-title text-decoration-none text-dark"
                                        data-bs-toggle="modal" data-bs-target="#modal-{{ $item->id }}"
                                        data-task-id="{{ $item->id }}">
                                        {{ $item->title }}
                                    </a> --}}
                                    <a href="{{ route('tasks.details', $item->id) }}"
                                        class="kanban-card-title text-decoration-none text-dark">

                                        {{ $item->title }}
                                        <p>Ticket Number : {{ $item->id }}</p>
                                    </a>
                                    @if (illuminate\Support\Facades\Auth::user()->roles[0]->name == 'User')
                                        @if ($item->user_id == illuminate\Support\Facades\Auth::user()->id)
                                            <select class="form-select status mt-2" name="status"
                                                data-task-id="{{ $item->id }}">
                                                @foreach ($statuses as $dropdownStatus)
                                                    <option value="{{ $dropdownStatus }}"
                                                        {{ $item->status === $dropdownStatus ? 'selected' : '' }}>
                                                        {{ ucfirst($dropdownStatus) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <p class="mt-2 text-capitalize rounded border border-secondary">
                                                {{ $item->status }}
                                            </p>
                                        @endif
                                    @else
                                        <select class="form-select status mt-2" name="status"
                                            data-task-id="{{ $item->id }}">
                                            @foreach ($statuses as $dropdownStatus)
                                                <option value="{{ $dropdownStatus }}"
                                                    {{ $item->status === $dropdownStatus ? 'selected' : '' }}>
                                                    {{ ucfirst($dropdownStatus) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif

                                    <div class="mt-2">
                                        @if (illuminate\Support\Facades\Auth::user()->roles[0]->name == 'User')
                                            <p>{{ explode(' ', $item->user->name)[0] }}</p>
                                        @else
                                            <select name="user_id" class="form-select user_id"
                                                data-task-id="{{ $item->id }}" id="user_id">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->user->id }}"
                                                        {{ $item->user_id == $user->user->id ? 'selected' : '' }}>
                                                        {{ explode(' ', $user->user->name)[0] }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>



                                {{-- <div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="modalLabel-{{ $item->id }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title" id="modalLabel-{{ $item->id }}">
                                                    {{ $item->title }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body" style="overflow: hidden;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <img src="{{ asset($item->attachment) }}" class="img-fluid"
                                                                width="100" alt="" />

                                                            <img id="preview" class="preview img-fluid"
                                                                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 9999;" />
                                                        </div>

                                                        <div class="d-flex gap-2"><b>Details : </b>
                                                            <p>{{ $item->detail }}</p>
                                                        </div>
                                                        <div class="d-flex gap-2"> <b>Assigned To : </b>
                                                            <p>{{ $item->user->name ?? '' }}</p>
                                                        </div>
                                                        <div class="d-flex gap-2"> <b>Priority : </b>
                                                            <p>{{ $item->priority }}</p>
                                                        </div>
                                                        <div class="d-flex gap-2"> <b>Deadline : </b>
                                                            <p>{{ $item->deadline }}</p>
                                                        </div>
                                                        <div class="d-flex gap-2"> <b>Status : </b>
                                                            <p>{{ $item->status }}</p>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ route('tasks.edit', $item->id) }}"
                                                                class="btn btn-sm btn-primary">

                                                                <i class="edit fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 ">
                                                        <div class="heading">
                                                            <h3>Comments</h3>
                                                            <hr>
                                                        </div>
                                                        <div class="comments">
                                                            @if ($item->comment && count($item->comment) > 0)
                                                                @foreach ($item->comment as $comment)
                                                                    <b>{{ explode(' ', $comment->user->name)[0] }} </b>
                                                                    <br> <br>
                                                                    <p class="text-muted">{{ $comment->comment }}</p>
                                                                    <hr>
                                                                @endforeach
                                                            @else
                                                                <div class="p-2 text-center">

                                                                    <p>No comments available for this task.</p>
                                                                </div>
                                                            @endif
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="text-box ">
                                                    <form action="{{ route('comments.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="task_id" value="{{ $item->id }}">
                                                        <div class="mb-3">
                                                            <div class="input-group comment-input mb-3">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Comment" aria-label="Enter Comment"
                                                                    name="comment" aria-describedby="button-addon2">
                                                                <button class="btn btn-primary" type="submit"
                                                                    id="button-addon2">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            @endforeach
                        </div>
                    @endif

                </div>
            @endforeach
            <div class="loader d-none">
                <svg class="mx-auto d-block" width="60" height="60" viewBox="0 0 60 60" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="loader_circle_1">
                        <!-- Rotating background elements -->
                        <circle id="Ellipse 11" cx="30" cy="5" r="5" fill="#f46613" />
                        <path id="Ellipse 12"
                            d="M35 55C35 57.7614 32.7614 60 30 60C27.2386 60 25 57.7614 25 55C25 52.2386 27.2386 50 30 50C32.7614 50 35 52.2386 35 55Z"
                            fill="#f46613" />
                        <path id="Ellipse 11_2"
                            d="M46.8302 10.8493C45.4495 13.2408 42.3916 14.0602 40.0001 12.6795C37.6086 11.2988 36.7893 8.24081 38.17 5.84935C39.5507 3.45788 42.6086 2.63851 45.0001 4.01922C47.3916 5.39993 48.2109 8.45788 46.8302 10.8493Z"
                            fill="#f46613" />
                        <path id="Ellipse 12_2"
                            d="M21.8302 54.1506C20.4495 56.5421 17.3916 57.3615 15.0001 55.9807C12.6086 54.6 11.7893 51.5421 13.17 49.1506C14.5507 46.7592 17.6086 45.9398 20.0001 47.3205C22.3916 48.7012 23.2109 51.7592 21.8302 54.1506Z"
                            fill="#f46613" />
                        <path id="Ellipse 11_3"
                            d="M54.1505 21.8301C51.759 23.2108 48.7011 22.3914 47.3204 20C45.9397 17.6085 46.759 14.5506 49.1505 13.1699C51.542 11.7891 54.5999 12.6085 55.9806 15C57.3613 17.3914 56.542 20.4494 54.1505 21.8301Z"
                            fill="#f46613" />
                        <path id="Ellipse 12_3"
                            d="M10.8492 46.8301C8.45776 48.2108 5.39981 47.3914 4.0191 45C2.63838 42.6085 3.45776 39.5506 5.84922 38.1699C8.24069 36.7891 11.2986 37.6085 12.6794 40C14.0601 42.3914 13.2407 45.4494 10.8492 46.8301Z"
                            fill="#f46613" />
                    </g>
                    <!-- Static central content -->
                    <circle cx="30" cy="30" r="10" fill="#f46613"></circle>
                </svg>
            </div>

        </div>
        <!-- Completed Column -->

        {{-- on change of the #user_id it should chnage the user name make ajax call update task  --}}
        <script>
            $(document).ready(function() {
                $('.user_id').on('change', function() {
                    var taskId = $(this).data('task-id');
                    var userId = $(this).val();
                    $.ajax({
                        url: "{{ route('tasks.updateUserId', ':taskId') }}".replace(':taskId', taskId),
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: userId,
                            taskId: taskId, // Include the taskId in the data
                        },
                        beforeSend: function() {
                            $('.loader').removeClass('d-none');
                        },
                        complete: function() {
                            $('.loader').addClass('d-none');
                        },
                        success: function(response) {
                            console.log(response);

                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Failed to update status.');
                            }
                        },
                        error: function() {
                            alert('An error occurred while updating the status.');
                        }
                    })
                })
            })
        </script>
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
        <script>
            function showPreview(src) {
                var preview = document.querySelector('.preview');
                preview.src = src;
                preview.style.display = "block";
                var closeButton = document.createElement('button');
                closeButton.type = 'button';
                closeButton.classList.add('btn-close');
                closeButton.style.position = 'absolute';
                closeButton.style.top = '20px';
                closeButton.style.right = '400px';
                closeButton.style.zIndex = '99999';
                closeButton.onclick = function() {
                    preview.style.display = "none";
                    closeButton.remove();
                }
                // closeButton.innerHTML = '<svg class="bi bi-x-lg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/><path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/></svg>';
                document.body.appendChild(closeButton);
            }
        </script>
    @endsection
