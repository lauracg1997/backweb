<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

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
            'subscribers'  => 'nullable|integer|min:0',
            'last_sent_at' => 'nullable|date',
        ]);

        return Newsletter::create($validated);
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        $validated = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'subscribers'  => 'nullable|integer|min:0',
            'last_sent_at' => 'nullable|date',
        ]);

        $newsletter->update($validated);
        return $newsletter;
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
