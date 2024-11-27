@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Team</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teams.store') }}" method="POST">
            @csrf
            <div class="mb-3 mt-5 d-flex gap-5">
                <h2>Project Name:</h2>
                <div class="mt-2">

                    @foreach ($project as $item)
                        <h3>{{ $item->title }} </h3>
                        <input type="hidden" value="{{ $item->id }}" name="project_id" id="">
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    @foreach ($allUsers as $user)
                        <div class="col-md-2 pt-2">
                            <label for="user_{{ $user->id }}">
                                <input type="checkbox" id="user_{{ $user->id }}" class="" name="user_id[]"
                                    value="{{ $user->id }}"
                                    {{ $project->first()->teams->pluck('user_id')->contains($user->id)? 'checked': '' }}>
                                {{ $user->name }}
                            </label>
                        </div>
                    @endforeach

                </div>

            </div>
            <button class="btn btn-primary" type="submit">Update Team</button>
        </form>
    </div>
@endsection
