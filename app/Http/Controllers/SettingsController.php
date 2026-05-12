<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\MailConfigService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function testSmtp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'smtpHost'  => 'required|string',
            'smtpPort'  => 'required',
            'smtpUser'  => 'required|string',
            'smtpPass'  => 'required|string',
            'fromEmail' => 'required|email',
            'fromName'  => 'nullable|string',
        ]);

        try {
            MailConfigService::applyAccount($data);

            Mail::raw('Test de conexión SMTP desde TalentionHR CMS. Si recibes este email, la configuración es correcta.', function ($message) use ($data) {
                $message->to($data['fromEmail'], $data['fromName'] ?? 'TalentionHR')
                        ->subject('✓ Test SMTP - TalentionHR');
            });

            return response()->json(['message' => 'Conexión exitosa. Email de prueba enviado a ' . $data['fromEmail']]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error de conexión: ' . $e->getMessage()], 422);
        }
    }
}
