<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\ActivityLog;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function index()
    {
        return Lead::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'status'  => 'in:Nuevo,Contactado,Convertido',
            'notes'   => 'nullable|string',
        ]);

        $lead = Lead::create($validated);
        ActivityLog::log('lead_created', "Nuevo lead registrado: {$lead->name}");

        try {
            MailConfigService::applyFromSettings();
            $html = view('emails.lead_confirmation', ['lead' => $lead])->render();
            Mail::html($html, function ($message) use ($lead) {
                $message->to($lead->email, $lead->name)
                        ->subject('Hemos recibido tu solicitud - TalentionHR');
            });
        } catch (\Exception $e) {
            // El lead se guarda aunque el email falle
        }

        return $lead;
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'name'    => 'sometimes|string|max:255',
            'email'   => 'sometimes|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'status'  => 'sometimes|in:Nuevo,Contactado,Convertido',
            'notes'   => 'nullable|string',
        ]);

        if (isset($validated['status']) && $validated['status'] !== $lead->status) {
            ActivityLog::log('lead_updated', "Lead {$lead->name} → estado: {$validated['status']}");
        }

        $lead->update($validated);
        return $lead;
    }

    public function destroy(Lead $lead)
    {
        ActivityLog::log('lead_deleted', "Lead eliminado: {$lead->name}");
        $lead->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
