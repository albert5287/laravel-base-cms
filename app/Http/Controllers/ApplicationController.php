<?php

namespace App\Http\Controllers;

use App\Application;
use App\Company;
use App\Http\Requests\ApplicationRequest;
use App\Module;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class ApplicationController extends BaseController
{
    protected $className = 'Application';
    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct(){
        $this->module = $this->getModule();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pageTitle = $this->module->title;

        $headerTable = ['name' => trans('strings.HEADER_TABLE_FOR_NAME_IN_APPLICATIONS')];

        return $this->setupTable($pageTitle, $headerTable);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $pageTitle = trans('strings.TITLE_CREATE_APPLICATION_PAGE');

        $companies = ['' => ''] + Company::lists('name', 'id')->all();

        $modules = $this->getListActiveContentModules();

        return view('application.create', compact('pageTitle', 'companies', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApplicationRequest $request
     * @return Response
     */
    public function store(ApplicationRequest $request)
    {
        $application = new Application();

        $this->insertUpdateApplication($application, $request);

        Session::forget('availableApps');

        flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_COMPANY'));

        return redirect('apps');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Application $application
     * @return Response
     */
    public function edit(Application $application)
    {
        $this->setReturnUrl();

        $companies = ['' => ''] + Company::lists('name', 'id')->all();

        $modules = $this->getListActiveContentModules();

        $pageTitle = trans('strings.TITLE_EDIT_APPLICATION_PAGE');

        return view('application.edit', compact('application', 'pageTitle', 'companies', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Application $application
     * @param ApplicationRequest $request
     * @return Response
     */
    public function update(Application $application, ApplicationRequest $request)
    {

        $this->insertUpdateApplication($application, $request);

        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_COMPANY'));

        Session::forget('availableApps');

        if(Session::has('currentApp') && Session::get('currentApp')->isEqual($application)){
            Session::put('currentApp', $application);
        }

        return $this->redirectPreviousUrl('companies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  application $application
     * @return Response
     */
    public function destroy(application $application)
    {
        $this->setReturnUrl();

        $application->delete();

        Session::forget('availableApps');

        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_COMPANY'));

        return $this->redirectPreviousUrl('apps');
    }

    /**
     * @param $application
     * @param $request
     */
    private function insertUpdateApplication($application, $request)
    {
        insertUpdateMultiLanguage($application, $request->all());

        $modulesToSync = NULL !== $request->input('_modules') ? $request->input('_modules') : [];

        $this->insertUpdateAvailableModules($application, $modulesToSync);
    }

    /**
     * @param $application
     * @param $modules
     */
    private function insertUpdateAvailableModules($application, $modules)
    {
        $application->availableModules()->sync($modules);
    }

    /**get a list of the active content modules
     * @return mixed
     */
    private function getListActiveContentModules()
    {
        return Module::activeContentModules()->get()->lists('title', 'id');
    }


}
