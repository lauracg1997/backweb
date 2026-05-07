<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Setting::all()->pluck('value', 'key');
        return response()->json($settings);
    }

    public function store(Request $request): JsonResponse
    {
        foreach ($request->all() as $key => $value) {
            Setting::setValue(
                $key,
                is_array($value) || is_bool($value) ? json_encode($value) : $value
            );
        }
        return response()->json(['message' => 'Configuración guardada correctamente.']);
    }
}
