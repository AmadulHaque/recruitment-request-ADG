<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case RESUME_RECEIVED = 'resume_received';
    case UNDER_REVIEW = 'under_review';
    case SENT_TO_CLIENT = 'sent_to_client';
    case INTERVIEW_INVITATION = 'interview_invitation';
    case INTERVIEW_WITH_CLIENT = 'interview_with_client';
    case REJECTION = 'rejection';
    case OFFER = 'offer';

    public function label(): string
    {
        return match ($this) {
            self::RESUME_RECEIVED => 'Resume received',
            self::UNDER_REVIEW => 'Under review by recruiter',
            self::SENT_TO_CLIENT => 'Sent to client',
            self::INTERVIEW_INVITATION => 'Interview invitation',
            self::INTERVIEW_WITH_CLIENT => 'Interview with client',
            self::REJECTION => 'Rejection',
            self::OFFER => 'Offer',
        };
    }
}

