<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Library API", version="1.0.0")
 */
class ReservationController
{
      /**
     * @OA\Get(
     *     path="/reservations",
     *     summary="List all reservations",
     *     @OA\Response(
     *         response=200,
     *         description="A list of reservations"
     *     )
     * )
     */
    public function listReservations()
    {
        $reservations = Reservation::with(['user', 'book'])->get();
        return response()->json($reservations);
    }
    /**
     * @OA\Post(
     *     path="/reservations/{bookId}",
     *     summary="Reserve a book",
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         required=true,
     *         description="ID of the book to reserve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "role"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="role", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book reserved successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Book not available"
     *     )
     * )
     */
    public function reserveBook(Request $request, $bookId)
    {
        $userId = $request->input('user_id');
        $userRole = $request->input('role');

        $book = Book::find($bookId);
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        if (!$book->availability) {
            return response()->json(['error' => 'Book not available'], 403);
        }

        $reservation = Reservation::create([
            'user_id' => $userId,
            'book_id' => $bookId,
            'reservation_date' => now(),
        ]);

        $book->availability = false;
        $book->save();

        return response()->json(['message' => 'Book reserved successfully', 'reservation' => $reservation]);
    }
    /**
     * @OA\Post(
     *     path="/reservations/return/{reservationId}",
     *     summary="Return a reserved book",
     *     @OA\Parameter(
     *         name="reservationId",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to return",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "role"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="role", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book returned successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reservation not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function returnBook(Request $request, $reservationId)
    {
        $userId = $request->input('user_id');
        $userRole = $request->input('role');

        $reservation = Reservation::find($reservationId);
        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        if ($reservation->user_id !== $userId) {  // Проверка прав пользователя
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $reservation->return_date = now(); // Обновление информации о резервации
        $reservation->save();

        $book = $reservation->book; // Обновление доступности книги
        $book->availability = true;
        $book->save();

        return response()->json(['message' => 'Book returned successfully']);
    }
    /**
     * @OA\Delete(
     *     path="/reservations/{reservationId}",
     *     summary="Delete a reservation",
     *     @OA\Parameter(
     *         name="reservationId",
     *         in="path",
     *         required=true,
     *         description="ID of the reservation to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reservation not found"
     *     )
     * )
     */
    public function deleteReservation($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}