<?php

namespace App\Exceptions\Application;

use App\Exceptions\AppException;
use Exception;

class StatusUpdateException extends AppException
{
    public function __construct(
        string $message = 'Failed to update application status',
        array $additionalData = [],
        ?Exception $previous = null
    ) {
        parent::__construct(
            $message,
            'APPLICATION_STATUS_UPDATE_FAILED',
            422,
            $additionalData,
            $previous
        );
    }
}

