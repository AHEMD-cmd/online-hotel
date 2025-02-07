<?php

namespace App\Traits;

trait AdminCheck
{
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->role == 'admin';
    }
    
    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->role == 'admin';
    }
}