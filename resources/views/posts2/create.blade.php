@extends('layouts2.master')

@section('content')
    <h1>Create a Post</h1>
    <hr>

    <form method="POST" action="/posts2" style="margin-bottom: 20px">

        <!--we use can use this to satisfy CSRF security checks for Laravel
            it'll give us an hidden form input, something like this;
            <input type="hidden" name="_token" value="P8eCBMVR46YewN7tMlUAAdVBiN1w7id1P1uTJ4XT">
        -->
            {{ csrf_field() }}


        <div class="form-group">
            <label for="title">Title:</label>
            <!-- we can & should use the HTML5 'required' attribute for form inputs as needed -->
            <input type="text" class="form-control" id="title" name="title"> <!-- required> -->
        </div>

        <div class="form-group">
            <label for="body">Body:</label>
            <textarea id="body" name="body" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-default">Publish</button>
    </form>

    <hr>

    @include ('layouts2.errors')


@endsection