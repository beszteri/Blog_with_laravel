@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-secondary">Go Back</a>
    <br><br>
    <h1>{{$post->title}}</h1>
    <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}">
    <br><br>
    <div>
        {{$post->body}}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">Edit</a>

            <form action="{{ route('posts.destroy',$post->id) }}" class="float-right " method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endif
    @endif
@endsection
