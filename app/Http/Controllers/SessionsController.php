<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{


    public function __construct(){
        /*
         * We will use the middleware 'guest' check to basically filter out
         * the Login related functions, if a user is already logged in
         */
        $this->middleware('guest', ['except' => 'destroy']);
    }


    public function create(){
        return view('sessions.create');
    }

    public function store(){
        // Attempt to authenticate the user.
        $validCredentials = auth()->attempt(request(['email', 'password']));

        if (! $validCredentials){
            return back()->withErrors([
               'message' => 'Please check your credentials.'
            ]);
        }
        // if so, then sign them in, then redirect to home page

        // if not, redirect them back
        return redirect()->home();

    }




    public function destroy(){
        # Sign out using the auth() helper
        //\Auth::logout();
        auth()->logout();

        # Redirect the user back to the 'home' page
        return redirect()->home();

    }
}
