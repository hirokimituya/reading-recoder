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

        if ($request->snackbar == 'on') {
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

            $b = $book->with('comments')->first()->toArray();
            $data['comments'] = $b['comments'];
        }
        else {
            $data['book'] = $request->all();
        }
        logger($data);

        return Inertia::render('BookForm', $data);
    }

    public function register(CommentRequest $request) 
    {
        if ($request->price == '-') {
            $request_book_data = $request->except(['id', 'date', 'content', 'price']);
        }
        else {
            $request_book_data = $request->except(['id', 'date', 'content']);
        }

        $book = Book::firstOrCreate(
            ['id' => $request->id],
            $request_book_data
        );

        $comment = new Comment(
            $request->only(['date', 'content'])
        );

        $book->comments()->save($comment);

        return redirect('/?snackbar=on');
    }
}
