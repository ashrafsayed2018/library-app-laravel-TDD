<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function store()
    {

        // store the book

       $book =  Book::create($this->validateRequest());

        return redirect($book->path());
    }


    public function update(Book $book)
    {

        $book->update($this->validateRequest());

        return redirect($book->path());
    }


    public function validateRequest() {

         // validating the data

        return  request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }

    public function destroy(Book $book)
    {


        $book->delete();

        return redirect('/books');
    }

}
