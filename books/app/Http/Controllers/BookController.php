<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Books",
 *     description="Operations related to books"
 * )
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Get all books",
     *     @OA\Response(
     *         response=200,
     *         description="A list of books",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *     )
     * )
     */
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Create a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author", "publication_year"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="author", type="string"),
     *             @OA\Property(property="publication_year", type="integer"),
     *             @OA\Property(property="available", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(Request $request)
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

    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Update a book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="author", type="string"),
     *             @OA\Property(property="publication_year", type="integer"),
     *             @OA\Property(property="available", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
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

    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Delete a book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the book to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Book deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(null, 204);
    }
}