<?php

namespace App\Helpers;

use App\Models\User;

class UserHelper
{
    public static function nameRole(User $user): string
    {
        if ($user->isAdmin()) {
            $role = 'Администратор';
        } elseif ($user->isModerator()) {
            $role = 'Модератор';
        } else {
            $role = 'Пользователь';
        }

        return $role;
    }

    public static function nameStatus(User $user): string
    {
        $status = ($user->isWait()) ? 'Ожидает' : 'Активен';

        return $status;
    }
}
