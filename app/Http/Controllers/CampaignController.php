<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

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
            'status'    => 'in:Activa,Borrador',
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
            'status'    => 'sometimes|in:Activa,Borrador',
            'open_rate' => 'nullable|string|max:20',
        ]);

        if (isset($validated['status']) && $validated['status'] !== $campaign->status && $validated['status'] === 'Activa') {
            ActivityLog::log('campaign_updated', "Campaña activada: \"{$campaign->name}\"");
        }

        $campaign->update($validated);
        return $campaign;
    }

    public function destroy(Campaign $campaign)
    {
        ActivityLog::log('campaign_deleted', "Campaña eliminada: \"{$campaign->name}\"");
        $campaign->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
