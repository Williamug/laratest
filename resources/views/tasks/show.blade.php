@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="page-header">
                <h2>Task Detail</h2>
            </div>
            <div class="card">
                <div class="card-header">
                    {{ $task->title }}
                </div>
                <div class="card-body">
                    {{ $task->description }}
                </div>
                <div class="card-footer">
                    @can('update', $task)
                    <a href="/tasks/{{$task->id}}/edit" class="btn btn-warning">Edit Task</a>
                    <form action="/tasks/{{ $task->id }}" method="post" style="float:right">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection