<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\Lead;
use App\Models\ActivityLog;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function index()
    {
        return Newsletter::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'subject'      => 'nullable|string|max:255',
            'content'      => 'nullable|string',
            'status'       => 'nullable|in:Borrador,Enviado',
            'subscribers'  => 'nullable|integer|min:0',
            'last_sent_at' => 'nullable|date',
        ]);

        return Newsletter::create($validated);
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        $validated = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'subject'      => 'nullable|string|max:255',
            'content'      => 'nullable|string',
            'status'       => 'nullable|in:Borrador,Enviado',
            'subscribers'  => 'nullable|integer|min:0',
            'last_sent_at' => 'nullable|date',
        ]);

        $newsletter->update($validated);
        return $newsletter;
    }

    public function send(Newsletter $newsletter)
    {
        if (!$newsletter->subject || !$newsletter->content) {
            return response()->json(['message' => 'El newsletter necesita asunto y contenido para poder enviarse.'], 422);
        }

        $leads = Lead::whereNotNull('email')->get();

        if ($leads->isEmpty()) {
            return response()->json(['message' => 'No hay suscriptores con email a quién enviar.'], 422);
        }

        MailConfigService::applyFromSettings();
        $logoPath = public_path('images/logo.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;
        $sent = 0;
        $errors = 0;

        foreach ($leads as $lead) {
            try {
                Mail::html(
                    view('emails.campaign', [
                        'subject' => $newsletter->subject,
                        'content' => $newsletter->content,
                        'logoUrl' => $logoBase64,
                    ])->render(),
                    function ($message) use ($lead, $newsletter) {
                        $message->to($lead->email, $lead->name)
                                ->subject($newsletter->subject);
                    }
                );
                $sent++;
            } catch (\Exception $e) {
                \Log::error('Newsletter send error: ' . $e->getMessage());
                $errors++;
            }
        }

        $newsletter->update([
            'status'       => 'Enviado',
            'sent_at'      => now(),
            'last_sent_at' => now()->toDateString(),
            'subscribers'  => $sent,
        ]);

        ActivityLog::log('newsletter_sent', "Newsletter enviado: \"{$newsletter->name}\" → {$sent} emails");

        return response()->json([
            'message' => "Newsletter enviado a {$sent} destinatarios." . ($errors > 0 ? " {$errors} fallaron." : ''),
            'sent'    => $sent,
            'errors'  => $errors,
        ]);
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
