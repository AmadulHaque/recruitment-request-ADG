<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Services\RecruitmentRequestServiceInterface;
use App\DTOs\CreateRecruitmentRequestDTO;
use App\Enums\Urgency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreRecruitmentRequestRequest;
use App\Http\Resources\RecruitmentRequestResource;
use Illuminate\Http\Request;

class RecruitmentRequestController extends Controller
{
    public function __construct(
        private readonly RecruitmentRequestServiceInterface $service
    ) {
    }

    public function index(Request $request)
    {
        $clientId = $request->query('client_id');
        $requests = $this->service->listForClient($clientId ?? '');
        return RecruitmentRequestResource::collection($requests);
    }

    public function store(StoreRecruitmentRequestRequest $request)
    {
        $dto = new CreateRecruitmentRequestDTO(
            clientId: $request->string('client_id'),
            position: $request->string('position'),
            jobDescription: $request->string('job_description'),
            numEmployees: $request->integer('num_employees'),
            salaryMin: $request->float('salary_min'),
            salaryMax: $request->float('salary_max'),
            urgency: Urgency::from($request->string('urgency')),
            contactPhone: $request->string('contact_phone'),
            contactEmail: $request->string('contact_email'),
        );

        $created = $this->service->create($dto);
        return new RecruitmentRequestResource($created->load('attachments'));
    }

    public function show(string $id)
    {
        $requestModel = \App\Models\RecruitmentRequest::with(['attachments'])->findOrFail($id);
        return new RecruitmentRequestResource($requestModel);
    }

    public function update(StoreRecruitmentRequestRequest $request, string $id)
    {
        $model = \App\Models\RecruitmentRequest::findOrFail($id);
        $model->fill($request->validated());
        $model->save();
        return new RecruitmentRequestResource($model->fresh('attachments'));
    }

    public function destroy(string $id)
    {
        $model = \App\Models\RecruitmentRequest::findOrFail($id);
        $model->delete();
        return response()->json(['success' => true]);
    }
}

