<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Custom functions created by me
    public static function incomplete(){

        /*
         * we use the 'static' keyword to reference the static object,
         * in the same way we use the 'this' keyword to reference an instance of the object
         */
        return static::where('completed', 0)->get();
    }

    /*
     *  Here is a special 'query-scoped' function, basically a wrapper around a particular query
     *  where we know that any function name
     *  declared here (as it extends Model) prepended with 'scope' will be treated as such
     *
     *  The function is referenced by calling '->ncomplete'
     *  > this seems to function like a callback wherein calling 'ncomplete' will call some
     *  > eloquent function, that will then call this function, passing in a value for $query
     *  > as default first argument
     */
    public function scopeNcomplete($query){
        return $query->where('completed', 0);
    }



}
