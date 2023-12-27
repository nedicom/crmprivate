<?php

namespace App\Models\Enums\Leads;

enum Status: string
{
    case Entered    = 'поступил';
    case In_Working = 'в работе';
    case Converted  = 'конвертирован';
    case Deleted    = 'удален';
    case Generated  = 'сгенерирован';
}
