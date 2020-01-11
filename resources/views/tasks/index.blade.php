@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="page-header">
                <h2>All Tasks</h2>
            </div>
            @foreach($tasks as $task)
            <div class="card mb-3">
                <div class="card-header"><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a></div>
                <div class="card-bordy p-3">
                    {{ $task->description }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection