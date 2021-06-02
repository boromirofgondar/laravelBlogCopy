<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/*
 *
 *Idea here is to use this as a Parent class to the other model classes
 * if there's going to be a bunch of things we want to repeat about.
*/

class MyModel extends Model
{

    /*
     * Done to avoid triggering a MassAssignmentException security related exception
     * if we try to write all these values to a DB row entry at once
     * ~is basically like whitelisting
     */
    protected $fillable = [];


    /*
     * Opposite is to create a blacklist, like so,
     * with DB columns we dont want writable..
     */
    protected $guarded = [];
}
