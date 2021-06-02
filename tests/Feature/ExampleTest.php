<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Post;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    /*
     * The RefreshDatabase class in particular will take care of cleaning out our DB after each run
     *
     * !!!!!!!!!!!Very important, be sure to change the Database being used in the .env
     * file from 'blog' to 'blog_testing' as including the 'RefreshDatabase' trait will wipe out your db
     *
     *
     */
    //use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        /*
         * Look for string existing on page
         */
        $this->get('/')->assertSee('Laravel Is a CMS');



        /*
         * >Given I have 2 records in the database that are posts,
         * and each one is posted a month apart
         *
         * >When I fetch the archives
         * >Then the response should be in the proper format
         */
        $first = factory(Post::class)->create();
        $second = factory(Post::class)->create([
            'created_at' => \Carbon\Carbon::now()->subMonth()
        ]);

        // This'll return us an array of records of Monthly-posts
        $posts = Post::archives();

        $this->assertCount(2, $posts);

        $this->assertEquals([
            [
                "year" => $first->created_at->format('Y'),
                "month" => $first->created_at->format('F'),
                "published" => 1
            ],
            [
                "year" => $second->created_at->format('Y'),
                "month" => $second->created_at->format('F'),
                "published" => 1
            ],


        ], $posts);


    }
}
