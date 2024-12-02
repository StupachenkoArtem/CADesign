<?php
namespace App\Http\Components\Schemas;

/**
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     required={"title", "author", "release_date"},
 *     @OA\Property(property="title", type="string", example="War and Peace"),
 *     @OA\Property(property="author", type="string", example="L. N. Tolstoy"),
 *     @OA\Property(property="publication_year", type="integer", example="1863-11-12"),
 * )
 */
class Book{
    //
}