<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Mail\Welcome;
use Illuminate\Http\Request;
use App\User;


class RegistrationController extends Controller
{

    public function create(){

        return view('registration.create');
    }

    /*
     * We will create a new user
     *
     * By type-hinting with the particular Request object here,
     * Laravel will execute certain actions on the Form (eg rules() ), before allowing the code to continue
     * execution here
     */
    public function store(RegistrationRequest $request){
        $request->persist();

        /*
         * Actions:
         * -Validate the form
         * -Create and save the user
         * ~Sign them in
         *
         * -Redirect to the home page
         */

        #1# Simplifying, and moving to RegistrationRequest instead ~ 'rules' method
//        #validate the posted data
//        $this->validate(request(), [
//            'name' => 'required',
//            'email' => 'required|email',
//            'password' => 'required|confirmed'  // 'confirmed' requires that the check field have name&id of '<name>_confirmation'
//        ]);
        #1#----------------------------


        #2# Simplifying, and moving to RegistrationRequest instead ~ 'persist' method
        #create and save the user
//       $user = User::create([
//           'name' => request('name'),
//            'email' => request('email'),
//            'password' => bcrypt(request('password'))
//       ]);

        #sign them in
        //\Auth::login();   // via the Auth-fascade
//        auth()->login($user);    // auth helper function
        //\Request::input, request()->input




        /*
         * Send an email to the user
         */
//        \Mail::to($user)->send(new Welcome($user));

        #2#---------------------------------



        /*
        * Flash a session value, that persists only for a single page load
        */
        session()->flash('message', 'Thanks so much for sighning up!');





        #redirect them to the homepage
//        return redirect('/');
        /*
         * Note that this will only work if you have defined a 'home' route
         * via the ' Route::get(...)->name('home') method
         */
        return redirect()->home();
    }

}
