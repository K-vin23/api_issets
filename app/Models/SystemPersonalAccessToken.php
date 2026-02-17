<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class SystemPersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $table = 'personal_access_tokens';
}
