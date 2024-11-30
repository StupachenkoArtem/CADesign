<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController
{
    public function listReservations()
    {
        $reservations = Reservation::with(['user', 'book'])->get();
        return response()->json($reservations);
    }

    public function reserveBook(Request $request, $bookId)
    {
        $userId = $request->input('user_id');
        $userRole = $request->input('role');

        $book = Book::find($bookId); // Проверка доступности книги
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        if (!$book->availability) {
            return response()->json(['error' => 'Book not available'], 403);
        }

        $reservation = Reservation::create([ // Создание новой резервации
            'user_id' => $userId,
            'book_id' => $bookId,
            'reservation_date' => now(),
        ]);

        $book->availability = false; // Обновление доступности книги
        $book->save();

        return response()->json(['message' => 'Book reserved successfully', 'reservation' => $reservation]);
    }

    public function returnBook(Request $request, $reservationId)
    {
        $userId = $request->input('user_id');
        $userRole = $request->input('role');

        $reservation = Reservation::find($reservationId); // Поиск резервации
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