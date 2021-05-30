<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class BookController extends Controller
{
    public function home(Request $request) 
    {
        $books = Book::orderBy(Book::CREATED_AT, 'desc')->orderBy('id')->paginate()->toArray();
        
        $data = [
            'books' => $books['data'],
            'bookCount' => $books['total'],
            'page' => $books['current_page'],
        ];

        if (session('snackbar') == true) {
            $data['snackbar'] = true;
        }
        
        return Inertia::render('Home', $data);
    }

    public function search() 
    {
        return Inertia::render('BookSearch');
    }

    public function form(Request $request) 
    {
        $book = Book::find($request->id);

        $data = [];
        if (!empty($book)) {
            $data['book'] = $book->toArray();
            
            $b = $book->comments()->get()->toArray();
            $data['comments'] = $b;
        }
        else {
            $data['book'] = $request->all();
        }

        return Inertia::render('BookForm', $data);
    }

    public function register(CommentRequest $request) 
    {
        $request_book_data = [
            'title' => $request->title,
            'author' => $request->author,
            'price' => is_numeric($request->price) ? $request->price : null,
            'publisher' => $request->publisher,
            'published' => date('Y-m-d', strtotime($request->published)),
            'image' => $request->image,
        ];

        $book = Book::firstOrCreate(
            ['id' => $request->id],
            $request_book_data
        );

        $comment = new Comment(
            $request->only(['date', 'content'])
        );

        $book->comments()->save($comment);

        return redirect()->route('home')->with('snackbar', true);
    }
}
