@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>Update a task</strong>
                </div>
                <div class="card-body">
                    <form action="/tasks/{{ $task->id }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter a title for your task" value="{{ $task->title }}" />
                        </div>
                        <div class="form-group">
                            <textarea name="description" id="" cols="30" rows="8" class="form-control"
                                placeholder="Provide a description for your task">{{ $task->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Edit Task
                        </button>
                    </form>
                    @if(count($errors))
                    <div class="alert alert-danger mt-3">
                        @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection