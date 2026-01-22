<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return ClientResource::collection(\App\Models\Client::latest()->paginate());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email'],
        ]);

        $client = \App\Models\Client::create($validated);
        return new ClientResource($client);
    }

    public function show(string $id)
    {
        $client = \App\Models\Client::findOrFail($id);
        return new ClientResource($client);
    }

    public function update(Request $request, string $id)
    {
        $client = \App\Models\Client::findOrFail($id);
        $client->fill($request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email'],
        ]));
        $client->save();
        return new ClientResource($client);
    }

    public function destroy(string $id)
    {
        $client = \App\Models\Client::findOrFail($id);
        $client->delete();
        return response()->json(['success' => true]);
    }
}

