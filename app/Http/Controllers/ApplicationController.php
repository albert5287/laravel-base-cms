<?php

namespace App\Http\Controllers;

use App\Application;
use App\Company;
use App\Http\Requests\ApplicationRequest;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ApplicationController extends BaseController
{
    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $class_name = 'Application';

        $module = Module::where('class', $class_name)->first();

        $page_title = $module->title;

        $header_table = ['name' => trans('strings.HEADER_TABLE_FOR_NAME_IN_APPLICATIONS')];

        return $this->setupIndexTable($page_title, $class_name, $header_table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title = trans('strings.TITLE_CREATE_APPLICATION_PAGE');

        $companies = ['' => ''] + Company::lists('name', 'id')->all();

        $modules = Module::all()->lists('title', 'id'); //I have to call first all because the title in modules are translatable

        return view('application.create', compact('page_title', 'companies', 'modules'));
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

        insertUpdateMultiLanguage($application, $request->all());

        $this->insertUpdateAvailableModules($application, $request->input('_modules'));

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

        $modules = Module::all()->lists('title', 'id');
        $page_title = trans('strings.TITLE_EDIT_APPLICATION_PAGE');
        return view('application.edit', compact('application', 'page_title', 'companies', 'modules'));
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
        insertUpdateMultiLanguage($application, $request->all());

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
     * @param $modules
     */
    private function insertUpdateAvailableModules($application, $modules)
    {
        $application->availableModules()->sync($modules);
    }
}
