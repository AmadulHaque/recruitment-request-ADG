<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateApplicationResource;
use Illuminate\Http\Request;

class CandidateApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $applications = \App\Models\CandidateApplication::with(['request', 'statusHistory'])->where('candidate_id', $user->id)->latest()->get();
        return CandidateApplicationResource::collection($applications);
    }

    public function show(string $id)
    {
        $application = \App\Models\CandidateApplication::with(['request', 'statusHistory', 'candidate'])->findOrFail($id);
        return new CandidateApplicationResource($application);
    }
}

