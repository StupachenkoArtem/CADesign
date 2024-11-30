<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function listUsers()
    {
        // Проверка на наличие прав администратора
        if (!$this->isAdmin()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $users = User::all();
        return response()->json($users);
    }

    public function getUser ($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User  not found'], 404);
        }
        return response()->json($user);
    }

    public function createUser (Request $request)
    {
        // Проверка на наличие прав администратора
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

    public function updateUser (Request $request, $id)
    {
        // Проверка на наличие прав администратора
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

    public function deleteUser ($id)
    {
        // Проверка на наличие прав администратора
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