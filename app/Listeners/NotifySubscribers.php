<?php

namespace App\Listeners;

use App\Events\ThreadCreated;
use Illuminate\Queue\InteractsWithQueue;


/*
 * ShouldQueue
 * used if we want to have the listener act as an async operation, and not
 * hold up execution of the code where the event was fired from
 */
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySubscribers #implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadCreated  $event
     * @return void
     */
    public function handle(ThreadCreated $event)
    {
        /*
         * When a ThreadCreated event fires, we will get corresponding ThreadCreated object
         *
         * e.g. can access ThreadCreated::thread value like;
         * $event->thread
         */

        var_dump($event->thread['name'] . ' was published to the forum');
    }
}
