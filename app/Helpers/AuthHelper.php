<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->id_rol === 1;
    }

    public static function isUser(): bool
    {
        return Auth::check() && Auth::user()->id_rol === 2;
    }

}
