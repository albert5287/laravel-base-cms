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
        if(Auth::check()){
            $user = Auth::user();
            $availableApps = getAvailableAppsForOneUser($user);
            if($availableApps->count() > 0){
                Session::put('currentApp', $availableApps[0]);
            }
            if($user->is('super.admin')){
                availableUsers();
            }
        }

        //TODO:get data when user is not superAdmin
        return $response;
    }
}
