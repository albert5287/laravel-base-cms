<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleApplicationRequest;
use App\Module;
use App\ModuleApplication;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ModuleApplicationController extends BaseController
{
    protected $className = 'ModuleApplication';
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

        $headerTable = ['name' => trans('strings.HEADER_TABLE_FOR_NAME_IN_MODULES_APPLICATION'),
            'module.name' => trans('strings.HEADER_TABLE_FOR_MODULE_TYPE_IN_MODULES_APPLICATION')];

        return $this->setupTable($pageTitle, $headerTable);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $pageTitle = trans('strings.TITLE_CREATE_MODULES_APPLICATION_PAGE');

        $modules = $this->getListAvailableContentModules();

        return view('modules-app.create', compact('pageTitle', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ModuleApplicationRequest $request
     * @return Response
     */
    public function store(ModuleApplicationRequest $request)
    {
        $moduleApplication = new ModuleApplication();

        insertUpdateMultiLanguage($moduleApplication, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_APPLICATION_MODULE'));

        return redirect('modules-app');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ModuleApplication $module
     * @return Response
     */
    public function edit(ModuleApplication $module)
    {
        $this->setReturnUrl();

        $pageTitle = trans('strings.TITLE_EDIT_COMPANY_PAGE');

        $modules = $this->getListAvailableContentModules();

        return view('modules-app.edit', compact('module', 'pageTitle', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ModuleApplication $module
     * @param ModuleApplicationRequest $request
     * @return Response
     */
    public function update(ModuleApplication $module, ModuleApplicationRequest $request)
    {
        insertUpdateMultiLanguage($module, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_APPLICATION_MODULE'));

        return $this->redirectPreviousUrl('modules-app');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ModuleApplication $module
     * @return Response
     */
    public function destroy(ModuleApplication $module)
    {
        $this->setReturnUrl();

        $module->delete();

        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_APPLICATION_MODULE'));

        return $this->redirectPreviousUrl('modules-app');
    }

    private function getListAvailableContentModules()
    {
        return ['' => ''] + Session::get('currentApp')->availableModules()->get()->lists('title', 'id')->all();
    }

    protected function getCustomCollection()
    {
        return ModuleApplication::withTranslation()
            ->where('application_id', '=', Session::get('currentApp')->id);
    }
}
