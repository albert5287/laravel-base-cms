<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 29.09.2015
 * Time: 16:35
 */
use Acme\Repositories\ApplicationRepository;
use App\Application;
use App\Language;
use App\Module;
use App\ModuleApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * get the current user authenticate
 * @return mixed
 */
function getCurrentUser(){
    return Auth::user();
}

/**
 * get the current app
 * @return mixed
 */
function getCurrentApp(){
    return Session::get('currentApp');
}

/**
 *
 * set the current app
 * @param $app
 */
function setCurrentApp($app){
    Session::put('currentApp', $app);
    Session::forget('availableUsers');
}

//TODO
//filter by active languages
//maybe change to the model
function getActiveLanguages()
{
    return Language::withTranslation()->get();
}

//TODO
//filter by active Modules
//maybe change to the model
/**
 * @return mixed
 */
function getAvailableModulesForAUser($user)
{
    $modules = Module::where('enabled', '=', true)
        ->where('show_sidebar', '=', true);
    if (!($user->is('super.admin'))) {
        $modules->where('only_super_admin', '=', false);
    }
    return $modules->withTranslation()->get();
}

function getAllActiveModules()
{
    return Module::where('enabled', '=', true)->withTranslation()->get();
}

/**
 * get Available Apps for a user
 * first it checks in the session,
 * if session is empty make the query
 * @return mixed
 */
function getAvailableApps()
{
    if (Session::has('availableApps')) {
        return Session::get('availableApps');
    } else {
        return getAvailableAppsForOneUser(getCurrentUser());
    }
}

function getAvailableUsers()
{
    if (Session::has('availableUsers')) {
        return Session::get('availableUsers');
    } else {
        return availableUsers();
    }
}

/**Function to get all the available app for a user
 * and put them in the session
 * @return mixed
 */
function getAvailableAppsForOneUser($user)
{
    if ($user->is('super.admin')) {
        $applicationRepository = new ApplicationRepository(new Application());
        $availableApps = $applicationRepository->orderBy('name')->get();
    } else {
        $availableApps = $user->applications;
    }
    Session::put('availableApps', $availableApps);
    return $availableApps;
}

/**Function to get all the available users
 * and put them in the session
 * @return mixed
 */
function availableUsers()
{
    $availableUsers = [];
    if (getCurrentUser()->is('super.admin')) {
        $availableUsers = getCurrentApp()
            ->users()
            ->where('user_id', '<>', getCurrentUser()->id)
            ->get();
    }
    if(Session::has('originalUser')){
        $availableUsers[] = Session::get('originalUser');
    }
    Session::put('availableUsers', $availableUsers);
    return $availableUsers;
}

/**
 * @return mixed
 */
function getContentModulesForCurrentApp()
{
    return ModuleApplication::getModulesApp(getCurrentApp()->id)->get();
}

/**
 * check if user have a permission in a class
 * @param $type
 * @param $className
 * @return bool
 */
function checkIfUserHavePermissions($type, $className){
    $user = getCurrentUser();
    $currentApp = getCurrentApp();
    return ($user->is('super.admin')
        || $user->is($currentApp->id.'.admin')
        || $user->can($type.'.'.$currentApp->id.'.'.strtolower($className)));
}

/**
 * function to check if a user if valid for showing the add button in a specific class
 * @param $className
 * @return bool
 */
function checkIfUserIsValidForAddButton($className)
{
    return ($className === 'Application' && getCurrentUser()->is('super.admin'))
            || ($className !== 'Application' && (checkIfUserHavePermissions('create', $className)));
}

/**
 * function to check if a user if valid for showing the delete button in a specific class
 * @param $className
 * @return bool
 */
function checkIfUserIsValidForDeleteButton($className)
{
    return ($className === 'Application' && getCurrentUser()->is('super.admin'))
        || ($className !== 'Application' && (checkIfUserHavePermissions('delete', $className)));
}

