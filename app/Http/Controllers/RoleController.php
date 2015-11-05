<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RoleController extends BaseController
{
    protected $className = 'Role';
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
        //dd($this->application->roles);
        $this->customCollection = $this->application->roles;
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
}
