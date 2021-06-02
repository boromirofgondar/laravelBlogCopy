@extends('layouts2.master')

@section('content')
    <h1>{{ $post->title }}</h1>

    @if (count($post->tags))
        <ul>
            @foreach ($post->tags as $tag)
                <li>
                    <a href="/posts2/tags/{{ $tag->name }}">{{ $tag->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h3>{{ $post->body }}</h3>

    <hr>
    <div style="margin-bottom: 20px" class="comments">
        <ul class="list-group">
            @foreach ($post->comments as $comment)
                <li class="list-group-item">
                    <strong>
                        {{ $comment->created_at->diffForHumans() }}: &nbsp;
                    </strong>
                    {{ $comment->body }}
                </li>
            @endforeach
        </ul>
    </div>


    <form method="POST" action="/posts2/{{ $post->id }}/comments" style="margin-bottom: 20px">

        <!-- most browsers only understand GET & POST, so if you want to do a DELETE or PATCH
            request, this helper method can be of assistance, it'll give us a hidden input to fake the request type;
            <input type="hidden" name="_method" value="PATCH">
         -->
       <!--   { method_field('PATCH') } -->

        <!--we use can use this to satisfy CSRF security checks for Laravel
            it'll give us an hidden form input, something like this;
            <input type="hidden" name="_token" value="P8eCBMVR46YewN7tMlUAAdVBiN1w7id1P1uTJ4XT">
        -->
        {{ csrf_field() }}


        <div class="form-group">
            <textarea name="body" placeholder="Your comment here." class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-default">Add Comment</button>
    </form>

    @include ('layouts2.errors')


@endsection