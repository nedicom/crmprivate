<?php

namespace App\Helpers;

class PaymentHelper
{
    public static function monthsList(): array
    {
        return [1 => 'январь', 2  => 'февраль',3  => 'март',4  => 'апрель',5  => 'май',6  => 'июнь',7  => 'июль',
            8  => 'август', 9  => 'сентябрь',10 => 'октябрь',11 => 'ноябрь', 12 => 'декабрь'];
    }
}
