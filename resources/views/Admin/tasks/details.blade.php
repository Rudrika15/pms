@extends('layouts.app')
@section('content')
    <style>
        .comments {
            max-height: 40vh;
            overflow-y: scroll;
        }

        .cmt-form {
            position: fixed;
            width: 30%;
        }

        .card {
            max-height: 70vh;
            min-height: 70vh;
            overflow-y: scroll;
        }
    </style>
    <div class="container">
        <img id="preview" class="preview img-fluid"
            style="justify-content: center; align-items: center; display: none; width: 900px; height: 550px; object-fit: contain; background-color: rgba(0, 0, 0, 0.5);  position: fixed;  z-index: 9999" />
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset($tasks->attachment) }}" class="img-fluid" width="100"
                                onclick="showPreview(this.src)" alt="" />
                            {{-- <img src="{{ asset($tasks->attachment) }}" class="img-fluid" width="100" alt="" /> --}}
                        </div>

                        <div class="d-flex gap-2 mt-5"> <b>Title : </b>
                            <p>{{ $tasks->title }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <b>ticket number : </b>
                            <p>{{ $tasks->id }}</p>
                        </div>
                        <div class="d-flex gap-2 "><b>Details: </b>
                            <p>{{ $tasks->detail }}</p>
                        </div>
                        <div class="d-flex gap-2"> <b>Assigned To : </b>
                            <p>{{ $tasks->user->name ?? '' }}</p>
                        </div>
                        <div class="d-flex gap-2"> <b>Priority : </b>
                            <p>{{ $tasks->priority }}</p>
                        </div>
                        <div class="d-flex gap-2"> <b>Deadline : </b>
                            <p>{{ $tasks->deadline }}</p>
                        </div>
                        <div class="d-flex gap-2"> <b>Status : </b>
                            <p>{{ $tasks->status }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('tasks.edit', $tasks->id) }}" class="btn btn-sm btn-primary">
                                <i class="edit fa fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-body">
                        <div class="heading">
                            <h3>Comments</h3>
                            <hr>
                        </div>
                        <div class="comments">
                            @if (count($comments) > 0)
                                @foreach ($comments as $item)
                                    <b>{{ explode(' ', $item->user->name)[0] }} </b> (
                                    {{ $item->created_at->diffForHumans() }} )
                                    <br> <br>
                                    <p class="text-muted">{{ $item->comment }}
                                    </p>
                                    <hr>
                                @endforeach
                            @else
                                <div class="p-2 text-center">
                                    <p>No comments available for this task.</p>
                                </div>
                                {{-- <hr> --}}
                            @endif

                        </div>
                        <div class="cmt-form">
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $tasks->id }}">
                                <div class="mb-3">
                                    <div class="input-group comment-input mb-3">
                                        <input type="text" class="form-control" placeholder="Enter Comment"
                                            aria-label="Enter Comment" name="comment" aria-describedby="button-addon2">
                                        <button class="btn btn-primary" type="submit" id="button-addon2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPreview(src) {
            var preview = document.querySelector('.preview');
            preview.src = src;
            preview.style.display = "flex";
            preview.style.justifyContent = "center";
            preview.style.alignItems = "center";

            var closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.classList.add('btn-close');
            closeButton.style.position = 'absolute';
            closeButton.style.top = '90px';
            closeButton.style.right = '300px';
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
