@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>Add a new task</strong>
                </div>
                <div class="card-body">
                    <form action="/tasks/create" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter a title for your task" />
                        </div>
                        <div class="form-group">
                            <textarea name="description" id="" cols="30" rows="8" class="form-control"
                                placeholder="Provide a description for your task"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Add Task
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