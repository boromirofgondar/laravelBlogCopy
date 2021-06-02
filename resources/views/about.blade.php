<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>About Laravel</title>
        <style type="text/css">
            h1.flashy {
                font-family: "DejaVu Sans", Arial, sans-serif;
                color: purple;
            }
            header.preText {
                font-size: small;
                color: lightseagreen;
            }
            article p span{
                font-size: medium;
                color: darkred;
            }
        </style>
        <script type="text/javascript">
            let pressMe = function(button){
                alert('Hello There');
                button.style.color = 'green';
            };
        </script>
    </head>

    <body>
        <main>
            <section>
                <header class="preText">About this page</header>
                <h1 class="flashy">All about Laravel</h1>
                <article>
                    <p>Your name happens to be:
                        <span>
                            <?php echo $name; ?>
                        </span>
                        , and you are
                        <span>
                            <?php echo $age ?>
                        </span>
                    </p>
                </article>

                <article>
                    <ul>
                        <?php foreach($tasks as $task): ?>
                        <li>
                            <?php echo $task; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </article>


                <button onclick="pressMe(document.querySelector('h1.flashy'))">Press Me</button>
            </section>
        </main>

    </body>

</html>