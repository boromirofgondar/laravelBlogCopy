<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{



    /**
     * Indicates if loading of the provider is deferred.
     * If true, then will only be resolved for cases where it is specifically called for, instead of all the time
     * ~if we have anything in our 'boot' method however, then we cannot defer.
     * @var bool
     */
    //protected $defer = true;




    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * We make a 'View-composer'
         * ~ can use \View::composer() fascade, or view()->composer() helper
         *
         * View-composers work in that they hook into whenever a view is called
         * and act as a callback essentially
         */


        $viewFunc = function($view){
            $view->with('archives', \App\Post::archives());


            //$view->with('tags', \App\Tag::pluck('name'));
            // We change this so that only Tags that have any posts (as noted in the post_tag pivot table)
            // will be included
            $view->with('tags', \App\Tag::has('posts')->pluck('name'));
        };

        /*
         * We need 'layouts2.aside' to always have access to the 'archives' val
         * ~note we are passing an anon-function-closure, but we could pass a classpath instead
         */
//        view()->composer('layouts2.aside', function($view){
//            $view->with('archives', \App\Post::archives());
//        });
        view()->composer('layouts2.aside', $viewFunc);

    }

    /**
     * Register any application services.
     *
     * This is specicically & exclusively for registering things into the service container
     *
     * @return void
     */
    public function register()
    {


        /*
         * Testing service binding and DI to some extent..
         * Going by this approach, we can use the app service such that each
         * time we instantiate an instance of the bound class,
         * via one of the shown methods, the callback as set will kick off prior
         * to the value/object being returned.
         */


        //App::bind('App\Billing\Stripe', function(){  // always apply to returned instances
        //$this->app->singleton(    // will work as well, since there is an app property on AppServiceProvider
        \App::singleton('App\Billing\Stripe', function(){   // note we can optionally have an 'app' param passed to the function; function($app)..

            return new \App\Billing\Stripe(config('services.stripe.secret'));
        });



    }
}
