<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return User::select('id', 'name', 'email', 'role', 'avatar_url', 'created_at')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|string|min:6',
            'role'       => 'required|in:Administrador,Editor',
            'avatar_url' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        ActivityLog::log('user_created', "Usuario creado: {$user->name} ({$user->role})");
        return User::select('id', 'name', 'email', 'role', 'avatar_url', 'created_at')->find($user->id);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'       => 'sometimes|string|max:255',
            'email'      => 'sometimes|email|unique:users,email,' . $user->id,
            'role'       => 'sometimes|in:Administrador,Editor',
            'avatar_url' => 'nullable|string',
        ]);

        $user->update($data);
        ActivityLog::log('user_updated', "Usuario actualizado: {$user->name}");
        return User::select('id', 'name', 'email', 'role', 'avatar_url', 'created_at')->find($user->id);
    }

    public function destroy(User $user)
    {
        ActivityLog::log('user_deleted', "Usuario eliminado: {$user->name}");
        $user->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->store('avatars', config('filesystems.default'));

        return response()->json([
            'url' => Storage::url($path),
        ]);
    }
}
