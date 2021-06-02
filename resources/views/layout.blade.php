<!DOCTYPE>
<html>
    <head>
        <title>My Application Yield</title>
    </head>

    <body>
        <!-- making use of some fancy 'blade' functionality
            Any blade that extends this file, will have all these contents
            and be able to stick in their own stuff via @ section('content') directives
        -->

        <div class="container">
            @yield('content')
        </div>

        <!-- only those blade that extend the page, and define
            @ section will show @ yield content
         -->
        <footer>
            @yield('footer')
        </footer>

    </body>

</html>