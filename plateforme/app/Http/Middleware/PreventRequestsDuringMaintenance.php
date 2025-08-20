<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;


class PreventRequestsDuringMaintenance
{
    public function handle($request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
    throw new HttpException(503, 'Service Unavailable');
}

        return $next($request);
    }
}
