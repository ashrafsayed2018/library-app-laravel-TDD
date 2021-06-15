<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorMangementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function author_can_be_created () {


        $this->post('/authors', [
            'name' => 'ashraf sayed',
            'dob'  => '11/16/1984'
        ]);

        $author = Author::all();

        $this->assertCount(1, $author);

        $this->assertInstanceOf(Carbon::class, $author->first()->dob);

        $this->assertEquals('1984/16/11', $author->first()->dob->format('Y/d/m'));
    }
}
