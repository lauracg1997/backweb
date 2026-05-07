<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index()
    {
        return JobOffer::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'required|string',
            'department'  => 'required|string',
        ]);

        return JobOffer::create($validated);
    }

    public function show(JobOffer $jobOffer)
    {
        return $jobOffer;
    }

    public function update(Request $request, JobOffer $jobOffer)
    {
        $jobOffer->update($request->all());
        return $jobOffer;
    }

    public function destroy(JobOffer $jobOffer)
    {
        $jobOffer->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

