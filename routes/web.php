<?php


/*
 * Testing service binding and DI to some extent..
 * Going by this approach, we can use the app service such that each
 * time we instantiate an instance of the bound class,
 * via one of the shown methods, the callback as set will kick off prior
 * to the value/object being returned.
 */
//App::singleton('App\Billing\Stripe', function(){  // always apply to and return same instance
//App::bind('App\Billing\Stripe', function(){
//
//    return new \App\Billing\Stripe(config('services.stripe.secret'));
//});
#dev note: this should instead be implemented in the AppServiceProvider.php with 'register', where its been moved to

#Any of these three approaches is fine
//$stripe = app('App\Billing\Stripe');
//$stripe = resolve('App\Billing\Stripe');
//$stripe = App::make('App\Billing\Stripe');
//dd($stripe);



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
    # Should not type out'.blade.php' portion
    # return view('welcome.blade.php');
});

# No need to type the /
//Route::get('/about', function(){
//    return view('about');
//});



# Note that the forward-slash is optional if not the document-root
Route::get('about', function(){

    $name = 'Norman';
    $age = 99;
    # compact squeezes given mixed variables into an assc array, based on their name & value
    $oneArray = compact('name', 'age');

    $tasks = [
        'Go to the store',
        'Finish my screencast',
        'Clean the house'
    ];




    # Here we pass an array parameter to the function
    $mydata = [ 'name' => 'Worldo', 'age' => 18 ];
    # Pass as 2nd arg, or use the 'with' method of the object
//    return view('about', $mydata);
//    return view('about')->with(compact('tasks'));
    return view('about')->with(compact('tasks', 'name', 'age'));


    /*
     * Argument must be an assc array,
     * so to pass an array you would need to do something like;
     *
     * $arrayValues = [
     *      namedArray = [...]
     * ]
     *
     * then do
     *
     * ..->with( $arrayValues )
     *
     * to get access to $namedArray in the View.
     *
     */
});



/*
 *  this'll return the about_blade.blade.php file which is the exact same
 *  as about.blade.php, but with 'blade' directives
 */
Route::get('about_blade', function(){
    $name = 'Norman';
    $age = 99;
    $tasks = [
        'Go to the store',
        'Finish my screencast',
        'Clean the house'
    ];
    return view('about_blade')->with(compact('tasks', 'name', 'age'));
});



/****************DATABASE STUFF************************/

/*
 * Fetching Database values the Laravel way
 */
Route::get('database', function (){

    # This is like a basic query, but we can use chained helper functions to better specify our query
    //$tasks = DB::table('tasks')->get();

    # This is a custom Eloquent object that will do the same thing as DB::table('tasks')
    $tasks = App\Task::all();



    # returning a database query from a route, Laravel will cast it as JSON
    // return $tasks;


    /*
     * Realize that tasks, is an array of DB-row like Objects, to access a column value
     * you need to do;
     * tasks[0]->body (or whatever the column name is)
     */
    return view('databast.database', compact('tasks'));

});



/*
 * Making use of laravel wildcard view finder
 * > apparently the syntax/name of the wildcard (~i.e. '{task}') itself is arbitrary
 * > all that matters is that it is there, so that a callback will be
 * > provided via the function (~i.e. '$id')
 */
Route::get('database/{task}', function($id){

    # Laravels Die&Dump function
    //dd($id);


    // $task = DB::table('tasks')->find($id);
    # This is a custom Eloquent object that will do the same thing as DB::table
    $task = App\Task::find($id);
    //dd($task);


    /*
     * Note the use of the '.' operator which now looks for
     * views such as 'dirA.dirB.file' according to the path;
     *  views/dirA/dirB/file.blade.php
     */
    return view('databast.datasing', compact('task'));

});


/*************CONTROLLERS*************************/
/*
 * This section is experimentation with Laravel Controllers to accomplish, the same things
 * as above from the DATABASE STUFF section, but with cleaner code
 */
Route::get('/tasks', 'TasksController@index');

Route::get('/tasks/{task}', 'TasksController@show');



/***************BLADE EXTRA*****************************/
/*
 * Testing some of the blade features;
 *
 * We will setup a data-structure as follows;
 *  Controller => PostsController
 *  Eloquent Model => Post
 *  Migration => create_posts_table
 *      MySQL Table => posts (after we migrate)
 *
 * We can one-shot this by the command;
 *  php artisan make:model Post -mc
 *
 */
Route::get('posts', 'PostsController@index');
Route::get('posts/show', 'PostsController@show');



/************REQUEST DATA & CSRF Ex****************/
/*
 *
 *
 * */
Route::get('posts2', 'PostsController@index2')->name('home');
Route::get('posts2/create', 'PostsController@create2');
Route::get('posts2/{post}', 'PostsController@show2');


/*
 * Some other Route types, to handle kinds of requests
 *  Route::put
 *  Route::patch
 *  Route::delete
 *  Route::post
 */
Route::post('posts2', 'PostsController@store2');
Route::post('posts2/{post}/comments', 'CommentsController@store');



/*********************Custom User Auth********************/

Route::get('/register', 'RegistrationController@create')->name('register');
Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');
//Note that best-practice is to make this a POST request, so others cannot sign you out
Route::get('/logout', 'SessionsController@destroy');


/***************TAGS Stuff*******************************/

/*
 * Doing something a little special here, where index2 can take an optional argument
 */
Route::get('/posts2/tags/{tag}', 'TagsController@index');

