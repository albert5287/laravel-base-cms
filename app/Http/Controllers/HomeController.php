<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends BaseController
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pageTitle = 'Home';
        return view('home', compact('pageTitle'));
    }

    /**
     * change the current app
     * @param int $appId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeCurrentApp($appId = 0)
    {
        if (!($appId < 0 || getAvailableApps()->where('id', (int)$appId)->count() === 0)) {
            Session::put('currentApp', getAvailableApps()->where('id', (int)$appId)->first());
            Session::forget('availableUsers');
        }
        return redirect('home');

    }

    /**
     * change the current User
     * @param int $user_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeUser($user_id)
    {
        //get the user
        $user = User::find($user_id);
        //check if user is super admin or in the session has the original user
        if (Auth::user()->is('super.admin') || Session::has('originalUser')) {
            //if the user is super admin forget originalUser
            if($user->is('super.admin')){
                Session::forget('originalUser');
            }
            //else put the original user in the session
            else{
                Session::put('originalUser', Auth::user());
            }
            //forget availableUsers
            Session::forget('availableUsers');
            //forget availableApps
            Session::forget('availableApps');
            //authenticate the user
            Auth::login($user);
        }
        return redirect('home');

    }
}
