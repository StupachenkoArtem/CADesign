<?php
namespace App\Http\Components\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="Artem"),
 *     @OA\Property(property="email", type="string", example="stupachenko03@gmail.com"),
 *     @OA\Property(property="password", type="string", example="q1w2e3r4t5y6q"),
 * )
 */
class User{
    //
}