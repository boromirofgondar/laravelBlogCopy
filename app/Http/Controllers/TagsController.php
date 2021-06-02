<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagsController extends Controller
{
    function index(Tag $tag){

        // With this, and thanks to the relationship setup, we can fetch all the posts assc with a given tag
        $posts = $tag->posts;

        return view('posts2.index', compact('posts'));
    }
}
