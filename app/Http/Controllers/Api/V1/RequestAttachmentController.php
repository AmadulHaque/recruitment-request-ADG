<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RequestAttachmentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequestAttachmentController extends Controller
{
    public function index(string $requestId)
    {
        $attachments = \App\Models\RequestAttachment::where('recruitment_request_id', $requestId)->get();
        return RequestAttachmentResource::collection($attachments);
    }

    public function store(Request $request, string $requestId)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        ]);

        $file = $validated['file'];
        $path = $file->store('requests', ['disk' => 'public']);

        $attachment = \App\Models\RequestAttachment::create([
            'recruitment_request_id' => $requestId,
            'path' => $path,
            'mime' => $file->getMimeType(),
            'original_name' => $file->getClientOriginalName(),
        ]);

        return new RequestAttachmentResource($attachment);
    }

    public function destroy(string $requestId, string $attachmentId)
    {
        $attachment = \App\Models\RequestAttachment::where('recruitment_request_id', $requestId)->findOrFail($attachmentId);
        Storage::disk('public')->delete($attachment->path);
        $attachment->delete();
        return response()->json(['success' => true]);
    }
}

