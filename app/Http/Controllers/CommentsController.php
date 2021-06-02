<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentsController extends Controller
{
    public function store(Post $post){

        #validate the posted data
        $this->validate(request(), [
            'body' => 'required|min:2'
        ]);


        /*
         * Regular way of creating a comment
         */
//        Comment::create([
//            'body' => request('body'),
//            'post_id' => $post->id
//        ]);


        # Elagant way of doing so, based on established DB relationships (see Post.php)
        # here we just pass off [ 'body' => value ] to the custom function, not bothering with the post->id
        $post->addComment(request('body'));

        //return redirect('/');
        return back();
    }
}
