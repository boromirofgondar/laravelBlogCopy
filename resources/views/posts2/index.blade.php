
@extends('layouts2.master')


@section('content')

    @foreach($posts as $post)
        @include('posts2.post')
    @endforeach


@endsection