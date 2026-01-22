<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class AppException extends Exception
{
    protected string $errorCode;
    protected int $httpStatusCode;
    protected array $additionalData = [];

    public function __construct(
        string $message = '',
        string $errorCode = 'GENERAL_ERROR',
        int $httpStatusCode = 500,
        array $additionalData = [],
        ?Exception $previous = null
    ) {
        $this->errorCode = $errorCode;
        $this->httpStatusCode = $httpStatusCode;
        $this->additionalData = $additionalData;

        parent::__construct($message, 0, $previous);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => $this->errorCode,
                'message' => $this->getMessage(),
                'data' => $this->additionalData,
            ]
        ], $this->httpStatusCode);
    }

    public function report(): void
    {
        Log::error($this->getMessage(), [
            'exception' => $this,
            'error_code' => $this->errorCode,
        ]);
    }
}
