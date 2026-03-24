<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens;

    protected $connection = 'oracle_sales';
    protected $table = 'online_app_admins';

    protected $fillable = ['mobile', 'password', 'role'];
    protected $hidden = ['password'];
}