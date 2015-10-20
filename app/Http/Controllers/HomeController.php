<?php

namespace App\Http\Controllers;

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
        $page_title = 'Home';
        return view('home', compact('page_title'));
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
        }
        return redirect('home');

    }
}
