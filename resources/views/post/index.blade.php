@extends('layouts.main')
@section('content')

    <h1>Posts</h1>
    @foreach ($posts as $post)
        <div class="d-flex gap-4">
            <b>{{ $post->id }}</b>
            <p>{{ $post->title }}</p>
        </div>
    @endforeach

@endsection