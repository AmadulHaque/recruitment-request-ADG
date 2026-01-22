<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AppException;
use Exception;

class CandidateAuthException extends AppException
{
    public function __construct(
        string $message = 'Failed to authenticate candidate',
        array $additionalData = [],
        ?Exception $previous = null
    ) {
        parent::__construct(
            $message,
            'CANDIDATE_AUTH_FAILED',
            401,
            $additionalData,
            $previous
        );
    }
}

