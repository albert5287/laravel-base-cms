<?php

namespace App\Http\Controllers;

use Acme\Repositories\ModuleApplicationRepository;
use App\Http\Requests\ModuleApplicationRequest;
use App\ModuleApplication;
use App\Http\Requests;

class ModuleApplicationController extends BaseController
{
    protected $className = 'ModuleApplication';
    protected $moduleApplicationRepository;

    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     * @param ModuleApplicationRepository $moduleApplicationRepository
     */
    public function __construct(ModuleApplicationRepository $moduleApplicationRepository){
        parent::__construct();
        $this->middleware('auth');
        $this->moduleApplicationRepository = $moduleApplicationRepository;
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
        $modules = $this->moduleApplicationRepository->getListAvailableContentModules(getCurrentApp());
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
        $this->moduleApplicationRepository->insertUpdateMultiLanguage($moduleApplication, $request->all());
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
        $modules = $this->moduleApplicationRepository->getListAvailableContentModules(getCurrentApp());
        return view('modules-app.edit', compact('module', 'pageTitle', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ModuleApplication $moduleApplication
     * @param ModuleApplicationRequest $request
     * @return Response
     */
    public function update(ModuleApplication $moduleApplication, ModuleApplicationRequest $request)
    {
        $this->moduleApplicationRepository->insertUpdateMultiLanguage($moduleApplication, $request->all());
        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_APPLICATION_MODULE'));
        return $this->redirectPreviousUrl('modules-app');
    }

    /**
     * Remove the specified resource from storage.
     * @param  ModuleApplication $moduleApplication
     * @return Response
     */
    public function destroy(ModuleApplication $moduleApplication)
    {
        $this->setReturnUrl();
        $this->moduleApplicationRepository->delete($moduleApplication);
        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_APPLICATION_MODULE'));
        return $this->redirectPreviousUrl('modules-app');
    }

    /**
     * create custom collection
     * @return mixed
     */
    protected function getCustomCollection()
    {
        return $this->moduleApplicationRepository
            ->where('application_id', '=', getCurrentApp()->id)
            ->withTranslation()
            ->get();
    }
}
