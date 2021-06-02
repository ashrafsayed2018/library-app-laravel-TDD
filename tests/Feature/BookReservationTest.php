<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{


    use RefreshDatabase;

    /** @test */

    public function a_book_can_be_added_to_a_library () {


        $this->withoutExceptionHandling();


        // if i hit an end point let say books i will store the book details

        $response = $this->post('/books', [
            'title' => 'this is a cool book',
            'author' => 'ashraf sayed'
        ]);


        // assert that the response is ok

        $response->assertOk();

        // assert that the count of books in the database is 1

        $this->assertCount(1, Book::all());

    }

    /** @test */

    public function a_title_is_required () {

        // $this->withoutExceptionHandling();

            // if i hit an end point and the title is not filled

            $response = $this->post('/books', [
                'title' => '',
                'author' => 'ashraf sayed'
            ]);



            // assert that the title is required

            $response->assertSessionHasErrors('title');

    }

    /** @test */

    public function an_author_is_required () {


        // $this->withoutExceptionHandling();

            // if i hit an end point and the author is not filled

            $response = $this->post('/books', [
                'title' => 'this is a cool book',
                'author' => ''
            ]);


            $response->assertSessionHasErrors('author');



    }

    /** @test */

    public function a_book_can_be_updated () {

        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'this is a cool book',
            'author' => 'ashraf sayed'
        ]);


        // get the first book

        $book = Book::first();


        // if we hit the patch request we will update the book

        $response = $this->patch("/books/{$book->id}", [
            'title' => 'the new title ',
            'author' => 'new author'
        ]);

        $this->assertEquals('the new title', Book::first()->title);
        $this->assertEquals('new author', Book::first()->author);

    }

}
