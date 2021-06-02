<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /*
    * Fetch/Associate with
    * ~ We are defining a many-to-many relationship
    * -A Post can have many Tags
    * -A Tag can have many Posts
     *
     * the post_tag table is a factor in the background
    */
    public function posts(){
        return $this->belongsToMany(Post::class);
    }


    /*
     * This'll be a special function to perform route-model binding
     * where we have a value other than an 'id' used as route,
     * but must transform it into such
     *
     * We are overriding an inherited method from Model, so that the
     * 'find' action is done by 'name' instead of 'id' of the tags table
     */
    public function getRouteKeyName(){
        return 'name';
    }
}
