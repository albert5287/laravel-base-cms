<?php

namespace App\Http\Controllers;

use Acme\Repositories\ApplicationRepository;
use Acme\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class UserController extends BaseController
{

    protected $className = 'User';
    protected $application;
    protected $userRepository;
    protected $applicationRepository;

    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     * @param UserRepository $userRepository
     * @param ApplicationRepository $applicationRepository
     */
    public function __construct(
        UserRepository $userRepository,
        ApplicationRepository $applicationRepository
    ) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->applicationRepository = $applicationRepository;
        $urlParameters = Route::current()->parameters();
        $this->application = $this->applicationRepository->find($urlParameters['app_id']);
        $this->customUrlEditParameters = [$urlParameters['app_id']];
        $this->customUrlDeleteParameters = [$urlParameters['app_id']];
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
        $rolesApplication = $this->userRepository->getListRolesToAssign($this->application, getCurrentUser());
        $pageTitle = trans('strings.TITLE_CREATE_PAGE_USER');
        $userRoles = [];
        return view('users.create', compact('pageTitle', 'app_id', 'rolesApplication', 'userRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request, $app_id)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $user = $this->userRepository->firstOrNew([
                'email' => $data['email'],
            ]);
            $roles = [];
            //if the user doesn't exist
            if (!$user->id) {
                //update user data
                $user = $this->userRepository->update($user,
                    [
                        'name' => $data['name'],
                        'password' => bcrypt($data['password'])
                    ]
                );
                flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_MODULE'));
            } //if the user exists
            else {
                //get user's roles from other apps
                $roles = $this->userRepository->getArrayListRolesByApp($user, $app_id, '<>');
                flash()->info(trans('strings.MESSAGE_INFO_USER_EXIST_ALREADY'));
            }
            //link user to the app
            $this->userRepository->attachToApplication($user, $data['app_id']);
            //sync user's roles
            $this->userRepository->syncRoles($user, $roles, $data['roleList']);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            flash()->success(trans('strings.MESSAGE_ERROR'));
            DB::rollback();
            // something went wrong
        }
        return $this->redirectPreviousUrl('apps/users/' . $app_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @param $app_id
     * @return Response
     */
    public function edit($user, $app_id)
    {
        $this->setReturnUrl();
        $pageTitle = trans('strings.TITLE_EDIT_NEWS_PAGE');
        $rolesApplication = $this->userRepository->getListRolesToAssign($this->application, getCurrentUser());
        $userRoles = $this->userRepository->getArrayListRolesByApp($user, $app_id);
        return view('users.edit', compact('user', 'pageTitle', 'app_id', 'rolesApplication', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $user
     * @param $app_id
     * @return Response
     */
    public function update(UserRequest $request, $user, $app_id)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            if ($data['password'] === '') {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }
            $this->userRepository->update($user, $data);
            //get user's roles from other apps
            $roles = $this->userRepository->getArrayListRolesByApp($user, $app_id, '<>');
            $this->userRepository->syncRoles($user, $roles, $data['roleList']);
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
     * @param $user
     * @return Response
     */
    public function destroy($user, $app_id)
    {
        $this->setReturnUrl();
        //get user's apps
        $userApps = $this->userRepository->getOtherApplications($user, $app_id);
        //if the user don't have other apps
        //the user is deleted
        if ($userApps->isEmpty()) {
            $this->userRepository->delete($user);
            flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_USER'));
        }
        //if the user is linked to other apps
        //unlink from App
        else {
            $this->userRepository->unlinkFromApp($user, $app_id);
            flash()->success(trans('strings.MESSAGE_USER_UNLINK_TO_APP'));
        }
        return $this->redirectPreviousUrl();
    }

    /**
     * function to get a custom collection of users
     * @return mixed
     */
    protected function getCustomCollection()
    {
        return $this->applicationRepository->getUsers($this->application);
    }

}
