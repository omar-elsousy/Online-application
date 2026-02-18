<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken;

class OraclePersonalAccessToken extends PersonalAccessToken
{
    protected $connection = 'oracle_lmidc';
    protected $table = 'online_personal_access_tokens';

    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at'   => 'datetime',
    ];

    // يحوّل Array → JSON قبل الإدخال
    public function setAbilitiesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['abilities'] = json_encode($value);
        } else {
            $this->attributes['abilities'] = $value;
        }
    }

    // يحوّل JSON → Array عند القراءة
    public function getAbilitiesAttribute($value)
    {
        $decoded = json_decode($value, true);
        return $decoded ?: [];
    }
}
