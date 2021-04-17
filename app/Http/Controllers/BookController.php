<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function home() {
        $books = Book::orderBy(Book::CREATED_AT, 'desc')->orderBy('id')->paginate()->toArray();
        
        $data = [
            'books' => $books['data'],
            'bookCount' => $books['total'],
            'page' => $books['current_page'],
        ];
        
        return Inertia::render('Home', $data);
    }

    public function search() {
        return Inertia::render('BookSearch');
    }

    public function form() {
        return Inertia::render('form');
    }

    public function index() {

    }
}
