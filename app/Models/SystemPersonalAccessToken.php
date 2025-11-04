<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class SystemPersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $table = 'system.personal_access_tokens';
}
