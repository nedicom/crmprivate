<?php

namespace App\Models\Enums\Tasks;

enum Type: string
{
    case Task = 'задача';
    case Ring = 'звонок';
    case Consultation = 'консультация';
    case Meeting = 'заседание';
    case Questioning = 'допрос';
}
