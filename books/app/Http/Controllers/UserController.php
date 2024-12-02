<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Operations related to users"
 * )
 */
class UserController
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="List all users",
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function listUsers()
    {
        
        if (!$this->isAdmin()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $users = User::all();
        return response()->json($users);
    }
    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Get a user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User  details",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User  not found"
     *     )
     * )
     */   
    public function getUser ($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User  not found'], 404);
        }
        return response()->json($user);
    }
    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "email", "role"},
     *             @OA\Property(property="username", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="role", type="string", enum={"admin", "user"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User  created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function createUser (Request $request)
    {
        if (!$this->isAdmin()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,user',
        ]);

        $user = User::create($data);
        return response()->json(['message' => 'User  created successfully', 'user' => $user], 201);
    }
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Update a user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="username", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="role", type="string", enum={"admin", "user"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User  updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User  not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function updateUser (Request $request, $id)
    {
        if (!$this->isAdmin()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User  not found'], 404);
        }

        $data = $request->validate([
            'username' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'sometimes|required|in:admin,user',
        ]);

        $user->update($data);
        return response()->json(['message' => 'User  updated successfully', 'user' => $user]);
    }
    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Delete a user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User  deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User  not found"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function deleteUser ($id)
    {
        if (!$this->isAdmin()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User  not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User  deleted successfully']);
    }

    private function isAdmin()
    {
        return isset($_GET['role']) && $_GET['role'] === 'admin';
    }
}