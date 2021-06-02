<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*
   * Fetch/Associate with Posts table
   *
   *
   *  SELECT * FROM posts
   *  INNER JOIN users
   *  ON users.id = posts.user_id
   *  WHERE users.id = 6;
   */
    public function posts(){
        // Note that Post::class == string 'App\Post'

        #? When this is called as a property, not a method, Laravel will know to 'eager-load' the relationship
        return $this->hasMany(Post::class);

    }



    /*
   * Fetch/Associate with Comments table
   *
   *
   *  SELECT * FROM comments
   *  INNER JOIN users
   *  ON users.id = comments.user_id
   *  WHERE users.id = 6;
   */
    public function comments(){
        // Note that Comment::class == string 'App\Comment'

        #? When this is called as a property, not a method, Laravel will know to 'eager-load' the relationship
        return $this->hasMany(Comment::class);

    }


    /*
        Elagant way of doing so, based on established DB relationships
        where it is assumed we implicity use this users 'id' value as the 'user_id'
     */
    public function publish(Post $post){
        $this->posts()->save($post);
    }


}
