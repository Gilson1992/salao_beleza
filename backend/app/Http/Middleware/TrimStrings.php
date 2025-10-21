<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * @var list<string>
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}
