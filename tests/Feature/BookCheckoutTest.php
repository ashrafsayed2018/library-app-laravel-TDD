<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Tests\TestCase;
use App\Reservation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookCheckoutTest extends TestCase
{


    use RefreshDatabase;
    /** @test */

    public function a_book_can_be_checkedout_by_a_signed_in_user() {

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();


        $this->actingAs($user)->post('/checkout/' .$book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        // $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }

     /** @test */

     public function only_a_signed_in_user_can_checkout_a_book() {


        $book = factory(Book::class)->create();

        $this->post('/checkout/'.$book->id)
             ->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());

    }

         /** @test */

         public function only_a_real_book_can_be_checkout() {

            $this->actingAs(factory(User::class)->create())->post('/checkout/123')
                 ->assertStatus(404);

            $this->assertCount(0, Reservation::all());

        }

          /** @test */

    public function a_book_can_be_checkedin_by_a_signed_in_user() {

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();


        $this->actingAs($user)->post('/checkin/' .$book->id);

        $this->assertCount(0, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        // $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }
}
