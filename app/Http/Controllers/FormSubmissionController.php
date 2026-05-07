<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    public function index()
    {
        return FormSubmission::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'surname'       => 'nullable|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:50',
            'company'       => 'nullable|string|max:255',
            'cargo'         => 'nullable|string|max:255',
            'employees'     => 'nullable|string|max:50',
            'message'       => 'nullable|string',
            'source'        => 'in:web,resource',
            'resource_name' => 'nullable|string|max:255',
        ]);

        $submission = FormSubmission::create($validated);
        ActivityLog::log('form_received', "Formulario recibido de: {$submission->name} ({$submission->email})");
        return $submission;
    }

    public function update(Request $request, FormSubmission $formSubmission)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pendiente,Contactado,Llamada realizada,Conversación mantenida',
        ]);

        $formSubmission->update($validated);
        return $formSubmission;
    }

    public function destroy(FormSubmission $formSubmission)
    {
        $formSubmission->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
