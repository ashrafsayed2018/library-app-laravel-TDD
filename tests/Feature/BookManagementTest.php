<?php

namespace Tests\Feature;

use App\Book;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{


    use RefreshDatabase;

    /** @test */

    public function a_book_can_be_added_to_a_library () {

        //

        // if i hit an end point let say books i will store the book details

        $response = $this->post('/books', [
            'title' => 'this is a cool book',
            'author_id' => 'ashraf sayed'
        ]);


        $book = Book::first();

        // assert that the count of books in the database is 1

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());

    }

    /** @test */

    public function a_title_is_required () {

            // if i hit an end point and the title is not filled

            $response = $this->post('/books', [
                'title' => '',
                'author_id' => 'ashraf sayed'
            ]);



            // assert that the title is required

            $response->assertSessionHasErrors('title');

    }

    /** @test */

    public function an_author_id_is_required () {

            // if i hit an end point and the author_id is not filled

            $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));


            $response->assertSessionHasErrors('author_id');



    }

    /** @test */

    public function a_book_can_be_updated () {

        $this->post('/books', $this->data());

        // get the first book

        $book = Book::first();


        // if we hit the patch request we will update the book

        $response = $this->patch($book->path(), [
            'title' => 'the new title ',
            'author_id' => 'new author'
        ]);


        $this->assertEquals('the new title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);

        $response->assertRedirect($book->fresh()->path());

    }

    /** @test */

    public function a_book_can_be_deleted () {

        $this->post('/books', $this->data());


        // get the first book

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');

    }

    /** @test */

    public function a_new_author_is_automatically_added () {

        // $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'this is a cool book',
            'author_id' => 'ashraf sayed'
        ]);


        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());

    }

    private function data() {

        return [
            'title' => 'this is a cool book',
            'author_id' => 'ashraf sayed'
        ];
    }

}
