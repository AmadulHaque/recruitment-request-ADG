<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case APPLIED = 'applied';
    case UNDER_REVIEW = 'under_review';
    case SENT_TO_COMPANY = 'sent_to_company';
    case INTERVIEW_INVITED = 'interview_invited';
    case INTERVIEW_COMPLETED = 'interview_completed';
}

