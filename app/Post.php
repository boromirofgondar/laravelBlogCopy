<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /*
     * Done to avoid triggering a MassAssignmentException security related exception
     * if we try to write all these values to a DB row entry at once
     * ~is basically like whitelisting
     */
    protected $fillable = ['title', 'body', 'user_id'];


    /*
     * Opposite is to create a blacklist, like so,
     * with DB columns we dont want writable..
     */
    protected $guarded = [];


    /*
     * Fetch/Associate with Comments table
     *
     *
     *  SELECT * FROM comments
     *  INNER JOIN posts
     *  ON posts.id = comments.post_id
     *  WHERE posts.id = 6;
     */
    public function comments(){
        // Note that Comment::class == string 'App\Comment'

        #? When this is called as a property, not a method, Laravel will know to 'eager-load' the relationship
        return $this->hasMany(Comment::class);

    }


    /*
   * Fetch/Associate with Users table
   *
   *
   *  SELECT * FROM users
   *  INNER JOIN posts
   *  ON posts.user_id = users.id
   *  WHERE posts.id = 6;
   */
    public function user(){
        // Note that User::class == string 'App\User'

        #? When this is called as a property, not a method, Laravel will know to 'eager-load' the relationship
        return $this->belongsTo(User::class);

    }



    /*
     * Fetch/Associate with
     * ~ We are defining a many-to-many relationship
     * -A Post can have many Tags
     * -A Tag can have many Posts
     *
     * the post_tag table is a factor in the background
     */
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }


    // The elegant way to add a comment through the CommentsController
    public function addComment($body){



//        Comment::create([
//            'body' => $body,
//            'post_id' => $this->id
//        ]);



        // ~ Even fancier...
        # Elagant way of doing so, based on established DB relationships
        # where it is assumed we implicity use this posts 'id' value as the 'post_id'
        $this->comments()->create(compact('body'));



        /*
         * this-comments => returns us a collection of all comments assc with this post
         * this-comments() => though we just give 'body', the 'post_id' will get applied
         *      behind the scenes, based on the relationship setup.
         */
    }

    /*
    *  Here is a special 'query-scoped' function, basically a wrapper around a particular query
    *  where we know that any function name
    *  declared here (as it extends Model) prepended with 'scope' will be treated as such
    *
    *  The function is referenced by calling '->filter'
    *  > this seems to function like a callback wherein calling 'filter' will call some
    *  > eloquent function, that will then call this function, passing in a value for $query
     * > as a default first argument
    */
    public function scopeFilter($query, $filters){

        if (isset($filters['month'])){

            //$posts->whereMonth('created_at', $month);
            /*
             * the 'month' request is a String, but whereMonth() goes by numbers, so we need to convert
             * the month-string to a number.
             * We can use the \Carbon\Carbon::parse static method to do this.
             *
             * Also be aware that strings stored in Model objects and their children, happen to be Carbon instances.
             */
            $query->whereMonth('created_at', \Carbon\Carbon::parse($filters['month'])->month);
        }

        if (isset($filters['year'])){
            $query->whereYear('created_at', $filters['year']);
        }


    }



    public static function archives(){
            return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toArray();
    }
}
