@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-secondary">Go Back</a>
    <br><br>
    <h1>{{$post->title}}</h1>
    <br>
    <div >
        {{$post->body}}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}</small>
    <hr>
    <a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">Edit</a>

    <form action="{{ route('posts.destroy',$post->id) }}" class="float-right "method="POST">
    @csrf
    @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
@endsection
