<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() // получение списка всех книг
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request) // создание новой книги
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_year' => 'required|integer',
            'available' => 'boolean',
        ]);

        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    public function update(Request $request, $id) // обновление существующей книги
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'publication_year' => 'sometimes|required|integer',
            'available' => 'sometimes|boolean',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());
        return response()->json($book);
    }

    public function destroy($id) // удаление книги
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(null, 204);
    }
}