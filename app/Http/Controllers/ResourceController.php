<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    public function index()
    {
        return Resource::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|in:Demo,Webinar,Guía,Plantilla',
            'description'  => 'nullable|string',
            'type'         => 'nullable|string',
            'size'         => 'nullable|string',
            'url'          => 'nullable|string',
            'status'       => 'in:active,disabled',
            'webinar_date' => 'nullable|date',
        ]);

        return Resource::create($validated);
    }

    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'category'     => 'sometimes|in:Demo,Webinar,Guía,Plantilla',
            'description'  => 'nullable|string',
            'type'         => 'nullable|string',
            'size'         => 'nullable|string',
            'url'          => 'nullable|string',
            'status'       => 'sometimes|in:active,disabled',
            'webinar_date' => 'nullable|date',
        ]);

        $resource->update($validated);
        return $resource;
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200',
        ]);

        $file = $request->file('file');
        $path = $file->store('resources', 'public');
        $bytes = $file->getSize();

        if ($bytes < 1024) {
            $size = $bytes . ' B';
        } elseif ($bytes < 1048576) {
            $size = round($bytes / 1024, 1) . ' KB';
        } else {
            $size = round($bytes / 1048576, 1) . ' MB';
        }

        return response()->json([
            'url'  => '/storage/' . $path,
            'type' => strtolower($file->getClientOriginalExtension()),
            'size' => $size,
        ]);
    }
}
