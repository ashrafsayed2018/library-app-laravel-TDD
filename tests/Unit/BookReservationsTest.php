<?php

namespace Tests\Unit;

use App\Book;
use App\User;
use Tests\TestCase;
use App\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationsTest extends TestCase
{

    use RefreshDatabase;
    /** @test */

    public function a_book_can_be_checked_out () {

        $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();

        // the user checkout a book

        $book->checkout($user);

        // assert to see count 1 in the reservations table

        $this->assertCount(1, Reservation::all());

        // assert that the user->id = the user_id in the reservation table

        $this->assertEquals($user->id, Reservation::first()->user_id);

        // assert that the book->id = the book_id in the reservation table

        $this->assertEquals($book->id, Reservation::first()->book_id);

        // assert that the time of cheched out at is equal to now
        $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }

        /** @test */

        public function a_book_can_be_returned () {

            $this->withoutExceptionHandling();

            $book = factory(Book::class)->create();

            $user = factory(User::class)->create();

            // the user checkout a book

            $book->checkout($user);

            // the user is checked in a book

            $book->checkin($user);


            // assert to see count 1 in the reservations table

            $this->assertCount(1, Reservation::all());

            // assert that the user->id = the user_id in the reservation table

            $this->assertEquals($user->id, Reservation::first()->user_id);

            // assert that the book->id = the book_id in the reservation table

            $this->assertEquals($book->id, Reservation::first()->book_id);

            // assert that checked_in_at not null

            $this->assertNotNull(Reservation::first()->checked_in_at);

            // assert that the time of cheched out at is equal to now
            $this->assertEquals(now(), Reservation::first()->checked_in_at);

        }

         /** @test */

         public function if_not_checked_out_exception_thrown () {

            $this->expectException(\Exception::class);

            $book = factory(Book::class)->create();

            $user = factory(User::class)->create();

            $book->checkin($user);

            $this->assertEquals(1, Reservation::all());

         }

        /** @test */

        public function a_user_can_check_out_a_book_twice () {

            $this->withoutExceptionHandling();

            $book = factory(Book::class)->create();

            $user = factory(User::class)->create();

            // the user checkout a book

            $book->checkout($user);

            // the user is checked in a book

            $book->checkin($user);

            // the user checkout a book

            $book->checkout($user);

            // assert to see count 1 in the reservations table

            $this->assertCount(2, Reservation::all());

            // assert that the user->id = the user_id in the reservation table

            $this->assertEquals($user->id, Reservation::find(2)->user_id);

            // assert that the book->id = the book_id in the reservation table

            $this->assertEquals($book->id, Reservation::find(2)->book_id);

            // assert that checked_in_at not null

            $this->assertNull(Reservation::find(2)->checked_in_at);

            // assert that the time of cheched out at is equal to now

            $this->assertEquals(now(), Reservation::find(2)->checked_out_at);

            $book->checkin($user);

            // assert to see count 1 in the reservations table

            $this->assertCount(2, Reservation::all());

            // assert that the user->id = the user_id in the reservation table

            $this->assertEquals($user->id, Reservation::find(2)->user_id);

            // assert that the book->id = the book_id in the reservation table

            $this->assertEquals($book->id, Reservation::find(2)->book_id);

            // assert that checked_in_at not null

            $this->assertNotNull(Reservation::find(2)->checked_in_at);

            // assert that the time of cheched out at is equal to now

            $this->assertEquals(now(), Reservation::find(2)->checked_in_at);



        }
}
