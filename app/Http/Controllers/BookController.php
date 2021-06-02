<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function store()
    {

        // store the book

        Book::create($this->validateRequest());
    }


    public function update(Book $book)
    {

        $book->update($this->validateRequest());
    }


    public function validateRequest() {

         // validating the data

        return  request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }

}
