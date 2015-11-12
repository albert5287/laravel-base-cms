<?php

namespace App\Http\Controllers;

use Acme\Repositories\ApplicationRepository;
use Acme\Repositories\CompanyRepository;
use Acme\Repositories\ModuleRepository;
use Acme\Repositories\RoleRepository;
use App\Application;
use App\Company;
use App\Http\Requests\ApplicationRequest;
use App\Module;
use App\Http\Requests;
use Bican\Roles\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ApplicationController extends BaseController
{
    protected $className = 'Application';
    protected $applicationRepository;
    protected $companyRepository;
    protected $moduleRepository;
    protected $roleRepository;

    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     * @param ApplicationRepository $applicationRepository
     * @param CompanyRepository $companyRepository
     * @param ModuleRepository $moduleRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        ApplicationRepository $applicationRepository,
        CompanyRepository $companyRepository,
        ModuleRepository $moduleRepository,
        RoleRepository $roleRepository
    ) {
        parent::__construct();
        $this->middleware('auth');
        $this->applicationRepository = $applicationRepository;
        $this->companyRepository = $companyRepository;
        $this->moduleRepository = $moduleRepository;
        $this->roleRepository = $roleRepository;
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
        $companies = $this->companyRepository->getCompanyList();
        $modules = $this->moduleRepository->getListActiveContentModules();
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
        DB::beginTransaction();
        try {
            $this->applicationRepository->insertUpdateApplication($application, $request);
            //create admin role for the app
            $role = $this->roleRepository->create([
                'name' => 'Admin',
                'slug' => $application->id . '.' . 'admin'
            ]);
            //attach role to company
            $this->applicationRepository->attachRoles($application, $role);
            Session::forget('availableApps');
            flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_COMPANY'));
            DB::commit();
        } catch (\Exception $e) {
            flash()->success(trans('strings.MESSAGE_ERROR'));
            DB::rollback();
            // something went wrong
        }

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
        $companies = $this->companyRepository->getCompanyList();
        $modules = $this->moduleRepository->getListActiveContentModules();
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
        $this->applicationRepository->insertUpdateApplication($application, $request);
        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_COMPANY'));
        Session::forget('availableApps');
        if (Session::has('currentApp') && Session::get('currentApp')->isEqual($application)) {
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
        $this->applicationRepository->delete($application);
        Session::forget('availableApps');
        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_COMPANY'));
        return $this->redirectPreviousUrl('apps');
    }

    /**
     * function to get a custom collection of users
     * @return mixed
     */
    protected function getCustomCollection()
    {
        $user = getCurrentUser();
        //if user is super admin get all the apps
        if ($user->is('super.admin')) {
            return $this->applicationRepository->all();
        } //if not get only the current app
        else {
            return collect([getCurrentApp()]);
        }
    }


}
