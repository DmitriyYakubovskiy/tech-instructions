<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $users = User::all();

        return response()->json([
            'success' => 'Пользователь успешно удален.',
            'users' => $users
        ]);
    }

    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();

        $users = User::all();

        return response()->json([
            'success' => 'Пользователь заблокирован.',
            'users' => $users
        ]);
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = 0;
        $user->save();

        $users = User::all();

        return response()->json([
            'success' => 'Пользователь разблокирован.',
            'users' => $users
        ]);
    }
}
