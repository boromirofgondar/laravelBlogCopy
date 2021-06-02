<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Post;

class PostsController extends Controller
{

    /*
     * This constructor will be called each time we instantiate a PostsController
     * ~ only the named functions will be allowed to run without being auth.
     */
    public function __construct(){
        $this->middleware('auth')->except(['index', 'show', 'index2', 'show2']);

        // Note that the default behavior of 'auth' for not being logged in,
        // is to try to redirect you to a 'login' page.
        // So be sure to set up a Route::get(...)->name('login')
    }


    public function index(){
        return view('posts.index');
    }

    public function show(){
        return view('posts.show');
    }

    /*
     * This is for the REQUEST DATA & CSRF Ex,
     * so using 'posts2' folder
     */
    public function index2(){


        //$posts = Post::all();

        # Lets order the listing of posts
        //$posts = Post::latest()->get();
        # For selective querying, we will hold off on doing the get just yet
        //$posts = Post::orderBy('created_at', 'desc')->get();

        /*
         * This is kind of ugly & long, we can make it cleaner
         */
//        $posts = Post::latest();
//        if ($month = request('month')){
//
//            //$posts->whereMonth('created_at', $month);
//            /*
//             * the 'month' request is a String, but whereMonth() goes by numbers, so we need to convert
//             * the month-string to a number.
//             * We can use the \Carbon\Carbon::parse static method to do this.
//             *
//             * Also be aware that strings stored in Model objects and their children, happen to be Carbon instances.
//             */
//            $posts->whereMonth('created_at', \Carbon\Carbon::parse($month)->month);
//        }
//
//        if ($year = request('year')){
//            $posts->whereYear('created_at', $year);
//        }
//
//        $posts = $posts->get();

        /*
         *
         * A cleaner way to go about this... We use a custom 'query-scoped' function defined for Post
         */
        $posts = Post::latest()
            ->filter(request(['month', 'year']))
            ->get();


//        $archives = Post::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
//            ->groupBy('year', 'month')
//            ->orderByRaw('min(created_at) desc')
//            ->get()
//            ->toArray();
        # for clean up, and ease of code reuse, we will move this to a static archive method
//        $archives = Post::archives();



        /*
         * We now need the 'archives' value everywhere, as every page pretty much uses it..
         * We will use a magical 'Service-Provider' & 'View-composer' to do this
         */
        //return view('posts2.index', compact('posts', 'archives'));
        return view('posts2.index', compact('posts'));
    }


    public function show2(Post $post){
        return view('posts2.show', compact('post'));
    }

    public function create2(){
        return view('posts2.create');
    }


    /************POST responders*************************/
    public function store2(){

        /*
         * Do a Die&Dump of all the request data attained ( ~ like $_REQUEST[] array )
         *
         * request()->all() = array of all request params
         * request('param') = specific request param
         * request( ['p1', 'p2'] ) = array of specific request params
         *
         */

        // dd(request()->all());



        /*
         * We should be validating Recieved data server-side
         * we can do this with Laravels validation methods
         * we use an assc array with | separated constraints as the values
         *
         * If any of the submitted values fails, this will redirect back to the page
         * with a populated error object
         */

        $this->validate(request(), [
           'title' => 'required|max:100',
           'body' => 'required'
        ]);



        /*
         * Make a new Post object, Eloquent DB hook,
         * then use it to set values for a row entry to be saved to the 'posts' DB
         */
        # This is the long way
//        $post = new Post;
//        $post->body = request('body');
//        $post->title = request('title');
//        $post->save();
        /*
         * This is the shorter, cleaner way, but;
         * this will trigger a MassAssignmentException security related exception, unless
         * we make efforts to allow certain manners of mass assignment via the
         * '$fillable' member of the Eloquent Model class
         */
//        Post::create([
//            'title' => request('title'),
//            'body' => request('body'),
//
//            //'user_id' => auth()->user->id
//            #auth() will have this info, since the user will be logged in, and users table has 'id'
//            'user_id' => auth()->id()
//        ]);

        /*
         * Here is an even fancier OOP way of doing things
         * -We use \Auth::user() to get object of present User instance that is logged in
         * -We create a new Post object, instantiated with the values request() will give as an assc array
         * -We pass the Post object to the User->publish function we made to do the work from above
         */
        auth()->user()->publish(
            new Post(request(['title', 'body']))
        );


        /*
        * Flash a session value, that persists only for a single page load
        */
        session()->flash('message', 'Your message has been published.');


        # And then redirect to the home page; (~this is nicer than the 'header' function)
        return redirect('/posts2');

    }

}
