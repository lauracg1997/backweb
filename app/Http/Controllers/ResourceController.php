<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ActivityLog;
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

        $resource = Resource::create($validated);
        ActivityLog::log('resource_created', "Recurso creado: \"{$resource->name}\"");
        return $resource;
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
        ActivityLog::log('resource_updated', "Recurso actualizado: \"{$resource->name}\"");
        return $resource;
    }

    public function destroy(Resource $resource)
    {
        ActivityLog::log('resource_deleted', "Recurso eliminado: \"{$resource->name}\"");
        $resource->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200',
        ]);

        $file = $request->file('file');
        $path = $file->store('resources', config('filesystems.default'));
        $bytes = $file->getSize();

        if ($bytes < 1024) {
            $size = $bytes . ' B';
        } elseif ($bytes < 1048576) {
            $size = round($bytes / 1024, 1) . ' KB';
        } else {
            $size = round($bytes / 1048576, 1) . ' MB';
        }

        return response()->json([
            'url'  => Storage::url($path),
            'type' => strtolower($file->getClientOriginalExtension()),
            'size' => $size,
        ]);
    }
}
