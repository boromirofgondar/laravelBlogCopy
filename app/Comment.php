<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /*
    * Done to avoid triggering a MassAssignmentException security related exception
    * if we try to write all these values to a DB row entry at once
    * ~is basically like whitelisting
    */
    protected $fillable = ['post_id', 'body'];


    /*
     * Opposite is to create a blacklist, like so,
     * with DB columns we dont want writable..
     */
    protected $guarded = [];



    /*
    * Fetch/Associate with Posts table
     *
     * ~ this is like;
     *   SELECT * FROM posts
     *   INNER JOIN comments
     *   ON posts.id = comments.post_id
     *   WHERE comments.id = <ID>;
    */
    public function post(){

        #? When this is called as a property, not a method
        #? Laravel will know to 'eager-load' the relationship
        return $this->belongsTo(Post::class);
    }



    /*
   * Fetch/Associate with Users table
    *
    * ~ this is like;
    *   SELECT * FROM users
    *   INNER JOIN comments
    *   ON users.id = comments.user_id
    *   WHERE comments.id = <ID>;
   */
    public function user(){

        #? When this is called as a property, not a method
        #? Laravel will know to 'eager-load' the relationship
        return $this->belongsTo(User::class);
    }

}
