<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Database tests</title>
    </head>

    <body>
        <main>
           <ul>
               @foreach($tasks as $task)

                   <li>
                       <a href="/database/{{$task->id}}">{{ $task->body }}</a>
                       <p>{{ $task->created_at }}</p>
                   </li>

               @endforeach
           </ul>
        </main>
    </body>

</html>