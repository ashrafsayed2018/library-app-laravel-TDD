<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Book $book)
    {

        $user = auth()->user();
        $book->checkout($user);
    }
}
