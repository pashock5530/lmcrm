<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelAgentOrSalesmanUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Sentinel::getUser();
        $agent = Sentinel::findRoleBySlug('agent');
        $salesman = Sentinel::findRoleBySlug('salesman');

        if (!$user->inRole($agent) && !$user->inRole($salesman)) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
