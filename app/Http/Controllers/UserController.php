<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class UserController extends BaseController
{

    protected $className = 'User';
    protected $application;

    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct(){
        $urlParameters = Route::current()->parameters();
        $this->application = Application::find($urlParameters['app_id']);
        $this->module = $this->getModule();
        $this->customCollection = $this->application->users;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index($app_id)
    {
        $pageTitle = $this->module->title;

        $headerTable = ['name' => trans('strings.LABEL_NAME'), 'email' => trans('strings.LABEL_EMAIL')];

        return $this->setupTable($pageTitle, $headerTable, $app_id, 'users.index', $this->application);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $app_id
     * @return Response
     */
    public function create($app_id)
    {
        $this->setReturnUrl();
        $rolesApplication = $this->getRolesApplication();
        $pageTitle = trans('strings.TITLE_CREATE_PAGE_USER');
        $userRoles = [];
        return view('users.create', compact('pageTitle', 'app_id', 'rolesApplication', 'userRoles'));
    }

    /**
     * @return mixed
     */
    private function getRolesApplication()
    {
        return $this->application
            ->roles()
            ->where('level', '<=', Auth::user()->level())
            ->get()
            ->lists('name', 'id');
    }
}
