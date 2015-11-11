<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        parent::__construct();
        $urlParameters = Route::current()->parameters();
        $this->application = Application::find($urlParameters['app_id']);
        $this->module = $this->getModule();
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
        $rolesApplication = $this->getRolesApplication();
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
            $user = User::firstOrNew([
                'email' => $data['email'],
            ]);
            $roles = [];
            //if the user doesn't exist, I create one
            if(!$user->id){
                //create user
                $user->name = $data['name'];
                $user->password = bcrypt($data['password']);
                $user->save();
                flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_MODULE'));
            }
            //if the user exists
            else{
                //get user's roles from other apps
                $roles = $user
                    ->getRolesByApp($app_id, '<>')
                    ->lists('id')
                    ->toArray();
                flash()->info(trans('strings.MESSAGE_INFO_USER_EXIST_ALREADY'));
            }
            //link user to the app
            $user->applications()->attach($data['app_id']);
            //sync user's roles
            $this->syncUserRoles($user, $roles, $data['roleList']);

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
     * @param $role_id
     * @param $app_id
     * @return Response
     */
    public function edit($user, $app_id)
    {
        $this->setReturnUrl();
        $pageTitle = trans('strings.TITLE_EDIT_NEWS_PAGE');
        $rolesApplication = $this->getRolesApplication();
        $userRoles = $user
            ->getRolesByApp($app_id)
            ->lists('id')
            ->toArray();
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
            if($data['password'] === ''){
                unset($data['password']);
            }
            else{
                $data['password'] = bcrypt($data['password']);
            }
            $user->update($data);
            //get user's roles from other apps
            $roles = $user
                ->getRolesByApp($app_id, '<>')
                ->lists('id')
                ->toArray();
            $this->syncUserRoles($user, $roles, $data['roleList']);

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
        $userApps = $user
            ->applications()
            ->where('application_id', '<>', $app_id)
            ->get();
        //if the user don't have other apps
        //the user is deleted
        if($userApps->isEmpty()){
            $user->delete();
            flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_USER'));
        }
        //if the user is linked to other apps
        //remove roles from app
        //and unlink user to the app
        else{
            //get user's roles from app
            $userRoles = $user
                ->getRolesByApp($app_id)
                ->lists('id')
                ->toArray();
            //remove those roles from the user
            foreach($userRoles as $role){
                $user->detachRole($role);
            }
            //remove link between user an app
            $user->applications()
                ->detach($app_id);
            flash()->success(trans('strings.MESSAGE_USER_UNLINK_TO_APP'));
        }
        return $this->redirectPreviousUrl();
    }

    /**
     * Function to get a list with the available roles
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

    /**
     * function to get a custom collection of users
     * @return mixed
     */
    protected function getCustomCollection()
    {
        return $this->application
            ->users()
            ->get();
    }

    /**
     * function to sync the users roles
     * @param $user
     * @param $oldRoles
     * @param $newRoles
     */
    private function syncUserRoles($user, $oldRoles, $newRoles)
    {
        //merge user's role from other with the one selected in this app
        $roles = array_merge($oldRoles, $newRoles);
        //sync user's roles
        $user->roles()->sync($roles);
    }
}
