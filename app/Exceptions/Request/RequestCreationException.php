<?php

namespace App\Exceptions\Request;

use App\Exceptions\AppException;
use Exception;

class RequestCreationException extends AppException
{
    public function __construct(
        string $message = 'Failed to create recruitment request',
        array $additionalData = [],
        ?Exception $previous = null
    ) {
        parent::__construct(
            $message,
            'REQUEST_CREATION_FAILED',
            422,
            $additionalData,
            $previous
        );
    }
}

