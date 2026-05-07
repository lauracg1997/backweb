<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        return Candidate::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'position'       => 'required|string|max:255',
            'cv_type'        => 'in:Normal,Prácticas Curriculares,Prácticas Extracurriculares',
            'status'         => 'in:Nuevo,En Selección,Entrevistado,Declinado',
            'cv_url'         => 'nullable|string',
            'location'       => 'nullable|string|max:255',
            'duracion_meses' => 'nullable|integer|min:0',
        ]);

        $candidate = Candidate::create($validated);
        ActivityLog::log('candidate_created', "Nuevo candidato: {$candidate->name} — {$candidate->position}");
        return $candidate;
    }

    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'name'           => 'sometimes|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'position'       => 'sometimes|string|max:255',
            'cv_type'        => 'sometimes|in:Normal,Prácticas Curriculares,Prácticas Extracurriculares',
            'status'         => 'sometimes|in:Nuevo,En Selección,Entrevistado,Declinado',
            'cv_url'         => 'nullable|string',
            'location'       => 'nullable|string|max:255',
            'duracion_meses' => 'nullable|integer|min:0',
        ]);

        if (isset($validated['status']) && $validated['status'] !== $candidate->status) {
            ActivityLog::log('candidate_updated', "Candidato {$candidate->name} → estado: {$validated['status']}");
        }

        $candidate->update($validated);
        return $candidate;
    }

    public function destroy(Candidate $candidate)
    {
        ActivityLog::log('candidate_deleted', "Candidato eliminado: {$candidate->name}");
        $candidate->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
