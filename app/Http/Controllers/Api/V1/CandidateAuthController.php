<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Services\CandidateServiceInterface;
use App\DTOs\CandidateLoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CandidateLoginRequest;

class CandidateAuthController extends Controller
{
    public function __construct(
        private readonly CandidateServiceInterface $candidateService
    ) {
    }

    public function login(CandidateLoginRequest $request)
    {
        $dto = new CandidateLoginDTO(
            phone: $request->input('phone'),
            candidateCode: $request->input('candidate_code'),
        );

        $candidate = $this->candidateService->authenticate($dto);
        $token = $candidate->createToken('candidate')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'candidate' => new \App\Http\Resources\CandidateResource($candidate),
        ]);
    }
}

