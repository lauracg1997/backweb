<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Si ese email existe, recibirás un código.']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            ['code' => $code, 'expires_at' => Carbon::now()->addMinutes(15), 'updated_at' => now(), 'created_at' => now()]
        );

        Mail::raw(
            "Tu código de recuperación de TalentionHR es: {$code}\n\nExpira en 15 minutos.",
            function ($message) use ($request, $code) {
                $message->to($request->email)
                        ->subject("Código de acceso TalentionHR: {$code}");
            }
        );

        return response()->json(['message' => 'Si ese email existe, recibirás un código.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'code'     => 'required|string|size:6',
            'password' => 'required|string|min:6',
        ]);

        $record = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Código incorrecto.'], 422);
        }

        if (Carbon::parse($record->expires_at)->isPast()) {
            return response()->json(['message' => 'El código ha expirado. Solicita uno nuevo.'], 422);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_codes')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Contraseña actualizada correctamente.']);
    }
}
