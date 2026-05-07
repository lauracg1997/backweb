<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'nullable|string',
            'status'          => 'in:Publicado,Borrador',
            'cover_image_url' => 'nullable|string',
        ]);

        $post = Post::create($validated);
        $action = $post->status === 'Publicado' ? 'publicada' : 'guardada como borrador';
        ActivityLog::log('post_created', "Entrada de blog {$action}: \"{$post->title}\"");
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'           => 'sometimes|string|max:255',
            'content'         => 'nullable|string',
            'status'          => 'sometimes|in:Publicado,Borrador',
            'cover_image_url' => 'nullable|string',
        ]);

        if (isset($validated['status']) && $validated['status'] !== $post->status) {
            $label = $validated['status'] === 'Publicado' ? 'publicada' : 'despublicada';
            ActivityLog::log('post_updated', "Entrada \"{$post->title}\" {$label}");
        }

        $post->update($validated);
        return $post;
    }

    public function destroy(Post $post)
    {
        ActivityLog::log('post_deleted', "Entrada eliminada: \"{$post->title}\"");
        $post->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
