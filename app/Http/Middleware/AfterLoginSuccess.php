<?php

namespace App\Http\Middleware;

use App\Application;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AfterLoginSuccess
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
        $response = $next($request);
        if(Auth::check() && Auth::user()->is('super.admin')){
            $availableApps = getAvailableAppsForOneUser();
            availableUsers();
        }
        if(sizeof($availableApps) > 0){
            Session::put('currentApp', $availableApps[0]);
        }
        //TODO:get data when user is not superAdmin
        return $response;
    }
}
