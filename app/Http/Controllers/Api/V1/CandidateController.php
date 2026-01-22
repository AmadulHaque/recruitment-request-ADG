<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidateResource;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        return CandidateResource::collection(\App\Models\Candidate::latest()->paginate());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'unique:candidates,phone'],
            'email' => ['nullable', 'email'],
            'candidate_code' => ['required', 'string', 'unique:candidates,candidate_code'],
        ]);

        $candidate = \App\Models\Candidate::create($validated);
        return new CandidateResource($candidate);
    }

    public function show(string $id)
    {
        $candidate = \App\Models\Candidate::findOrFail($id);
        return new CandidateResource($candidate);
    }

    public function update(Request $request, string $id)
    {
        $candidate = \App\Models\Candidate::findOrFail($id);
        $candidate->fill($request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'unique:candidates,phone,'.$candidate->id.',id'],
            'email' => ['nullable', 'email'],
            'candidate_code' => ['sometimes', 'string', 'unique:candidates,candidate_code,'.$candidate->id.',id'],
        ]));
        $candidate->save();
        return new CandidateResource($candidate);
    }

    public function destroy(string $id)
    {
        $candidate = \App\Models\Candidate::findOrFail($id);
        $candidate->delete();
        return response()->json(['success' => true]);
    }
}

