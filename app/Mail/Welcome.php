<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Welcome extends Mailable
/*
 * Note that any public variable you define in a Mailable class, will be available to
 * views referenced/called
 */

{
    use Queueable, SerializesModels;

    public $a;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->a = 1010;
        $this->user = $user;
        $b = 102;
        $c = $this->a + $b;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->a += 11;
        return $this->view('emails.welcome');
        # See note at top about why we do not need to include this in the view call
            //->with(['user' => $this->user ]);

    }
}
