<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Lead;
use App\Models\ActivityLog;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    public function index()
    {
        return Campaign::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'subject'   => 'nullable|string|max:255',
            'content'   => 'nullable|string',
            'status'    => 'in:Activa,Borrador,Enviada',
            'open_rate' => 'nullable|string|max:20',
        ]);

        $campaign = Campaign::create($validated);
        ActivityLog::log('campaign_created', "Campaña de email creada: \"{$campaign->name}\"");
        return $campaign;
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'name'      => 'sometimes|string|max:255',
            'subject'   => 'nullable|string|max:255',
            'content'   => 'nullable|string',
            'status'    => 'sometimes|in:Activa,Borrador,Enviada',
            'open_rate' => 'nullable|string|max:20',
        ]);

        $campaign->update($validated);
        return $campaign;
    }

    public function send(Campaign $campaign)
    {
        if (!$campaign->subject || !$campaign->content) {
            return response()->json(['message' => 'La campaña necesita asunto y contenido para poder enviarse.'], 422);
        }

        $leads = Lead::whereNotNull('email')->get();

        if ($leads->isEmpty()) {
            return response()->json(['message' => 'No hay leads con email a quién enviar.'], 422);
        }

        MailConfigService::applyFromSettings();
        $logoUrl = config('app.frontend_url') . '/imagenes/Logo TalentionHR (2).png';
        $sent = 0;
        $errors = 0;

        foreach ($leads as $lead) {
            try {
                Mail::html(
                    view('emails.campaign', [
                        'subject' => $campaign->subject,
                        'content' => $campaign->content,
                        'logoUrl' => $logoUrl,
                    ])->render(),
                    function ($message) use ($lead, $campaign) {
                        $message->to($lead->email, $lead->name)
                                ->subject($campaign->subject);
                    }
                );
                $sent++;
            } catch (\Exception $e) {
                \Log::error('Campaign send error: ' . $e->getMessage());
                $errors++;
            }
        }

        $campaign->update([
            'status'  => 'Enviada',
            'sent_at' => now(),
        ]);

        ActivityLog::log('campaign_sent', "Campaña enviada: \"{$campaign->name}\" → {$sent} emails");

        return response()->json([
            'message' => "Campaña enviada a {$sent} destinatarios." . ($errors > 0 ? " {$errors} fallaron." : ''),
            'sent'    => $sent,
            'errors'  => $errors,
        ]);
    }

    public function destroy(Campaign $campaign)
    {
        ActivityLog::log('campaign_deleted', "Campaña eliminada: \"{$campaign->name}\"");
        $campaign->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
