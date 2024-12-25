<?php

namespace App\Actions;

use Illuminate\Support\Str;

class GetAnonymousUserId
{
    public function getAnonymousUserId(): array|string
    {
        if ($userId = request()->cookie('anonymous_user_id')) {
            return $userId;
        }

        $userId = Str::uuid()->toString();
        cookie()->queue(cookie('anonymous_user_id', $userId, 60 * 24 * 30));

        return $userId;
    }
}
