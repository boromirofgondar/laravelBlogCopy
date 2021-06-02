<!-- we check for occurance of errors, via the 'count' helper function  -->
@if (count($errors))
    <div class="alert alert-danger">
        <u1>
            <!-- $errors is reserved and available in all views-->
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </u1>
    </div>
@endif