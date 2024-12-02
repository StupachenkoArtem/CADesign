<?php
namespace App\Http\Components\Schemas;

/**
 * @OA\Schema(
 *     schema="Reservation",
 *     type="object",
 *     required={"book_id", "user_id"},
 *     @OA\Property(property="book_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="reservation_date", type="integer", example="1863-11-12"),
 *     @OA\Property(property="return_date", type="integer", example="1863-11-12"),
 * )
 */
class Reservation{
    //
}