<?php

namespace App\Http\Controllers;

use Acme\Repositories\ApplicationRepository;
use Acme\Repositories\ModuleRepository;
use Acme\Repositories\PermissionRepository;
use Acme\Repositories\RoleRepository;
use App\Application;
use App\Http\Requests\RolesRequest;
use App\Module;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RoleController extends BaseController
{
    protected $className = 'Role';
    protected $application;
    protected $roleRepository;
    protected $applicationRepository;
    protected $moduleRepository;
    protected $permissionRepository;

    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     * @param RoleRepository $roleRepository
     * @param ApplicationRepository $applicationRepository
     * @param ModuleRepository $moduleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(
        RoleRepository $roleRepository,
        ApplicationRepository $applicationRepository,
        ModuleRepository $moduleRepository,
        PermissionRepository $permissionRepository
    ) {
        parent::__construct();
        $this->roleRepository = $roleRepository;
        $this->applicationRepository = $applicationRepository;
        $this->moduleRepository = $moduleRepository;
        $this->permissionRepository = $permissionRepository;
        $urlParameters = Route::current()->parameters(); //get the app_id from the url
        if (isset($urlParameters['app_id'])) {
            $this->application = $this->applicationRepository->find($urlParameters['app_id']); //set the application
            $this->customUrlEditParameters = [$urlParameters['app_id']];
        }
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $app_id
     * @return Response
     */

    public function index($app_id)
    {
        $pageTitle = $this->module->title;
        $headerTable = ['name' => trans('strings.LABEL_NAME'), 'description' => trans('strings.LABEL_DESCRIPTION')];
        return $this->setupTable($pageTitle, $headerTable, $app_id, 'roles.index', $this->application);
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
        $modulesApplication = $this->getModulesApplication();
        $pageTitle = trans('strings.TITLE_CREATE_PAGE_NEWS');
        $arrayPermissions = [];
        return view('roles.create', compact('pageTitle', 'app_id', 'modulesApplication', 'arrayPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RolesRequest $request
     * @return Response
     */
    public function store(RolesRequest $request, $app_id)
    {
        $data = $request->all();
        $permissions = isset($data['permissions']) ? array_keys($data['permissions']) : [];
        DB::beginTransaction();
        try {
            $role = $this->roleRepository->create([
                'name' => $data['name'],
                'slug' => $app_id . '.' . $data['name'],
                'description' => $data['description']
            ]);
            $this->applicationRepository->attachRoles($this->application, $role);
            $this->attachPermissionsRole($role, $permissions);
            flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_MODULE'));
            DB::commit();
            // all good
        } catch (\Exception $e) {
            flash()->success(trans('strings.MESSAGE_ERROR'));
            DB::rollback();
            // something went wrong
        }
        return $this->redirectPreviousUrl('apps/roles/' . $app_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $role_id
     * @param $app_id
     * @return Response
     */
    public function edit($role_id, $app_id)
    {
        $this->setReturnUrl();
        $role = $this->roleRepository->find($role_id);
        $pageTitle = trans('strings.TITLE_EDIT_NEWS_PAGE');
        $modulesApplication = $this->getModulesApplication();
        $arrayPermissions = $role->permissions->lists('name')->toArray();
        return view('roles.edit', compact('role', 'pageTitle', 'app_id', 'modulesApplication', 'arrayPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RolesRequest $request
     * @param $role_id
     * @return Response
     */
    public function update(RolesRequest $request, $role_id)
    {
        $data = $request->all();
        $role = $this->roleRepository->find($role_id);
        $permissions = isset($data['permissions']) ? array_keys($data['permissions']) : [];
        DB::beginTransaction();
        try {
            $this->roleRepository->update($role, $data);
            $role->detachAllPermissions();
            $this->attachPermissionsRole($role, $permissions);
            flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_MODULE'));
            DB::commit();
            // all good
        } catch (\Exception $e) {
            // something went wrong
            flash()->success(trans('strings.MESSAGE_ERROR'));
            DB::rollback();
        }
        return $this->redirectPreviousUrl('modules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $roles
     * @return Response
     */
    public function destroy($roles)
    {
        $this->setReturnUrl();
        $this->roleRepository->delete($roles);
        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_COMPANY'));
        return $this->redirectPreviousUrl();
    }

    /**Function To get all the modules of an application
     * @return mixed
     */
    private function getModulesApplication()
    {
        $modulesApp = $this->application->availableModules;
        $defaultModules = $this->moduleRepository->getDefaultAppModules();
        return $modulesApp->merge($defaultModules);
    }

    /**
     * function to attach permissions to a role
     * the function check if the permission exists if not it creates it
     * @param $role
     * @param $permissions
     */
    private function attachPermissionsRole($role, $permissions)
    {
        foreach ($permissions as $namePermission) {
            $permission = $this->permissionRepository->firstOrCreate([
                'name' => $namePermission,
                'slug' => Str::lower($namePermission)
            ]);
            $role->attachPermission($permission);
        }
    }

    /**
     * function to get a custom collection
     * @return mixed
     */
    protected function getCustomCollection()
    {
        return $this->applicationRepository->getRoles($this->application);
    }

}
