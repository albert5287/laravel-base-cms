<?php
use App\Application;
use App\Language;
use App\Module;
use App\ModuleApplication;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 29.09.2015
 * Time: 16:35
 */

function getCurrentUser(){
    return Auth::user();
}

function getCurrentApp(){
    return Session::get('currentApp');
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

//TODO: maybe change this to a base model and extend that model
function insertUpdateMultiLanguage($element, $newValues)
{
    foreach ($newValues as $key => $value) {
        if (strpos($key, '_') !== 0) {
            if (is_array($value)) {
                foreach ($value as $lang => $val) {
                    if ($val !== '') {
                        $element->translateOrNew($lang)->$key = $val;
                    }
                }
            } else {
                $element->$key = $value;
            }
        }
    }
    $element->save();
}

function getAvailableApps()
{
    if (Session::has('availableApps')) {
        return Session::get('availableApps');
    } else {
        return getAvailableAppsForOneUser(Auth::user());
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

//TODO: now is only for the super admin, complete for all kind of users
/**Function to get all the available app for a user
 * and put them in the session
 * @return mixed
 */
function getAvailableAppsForOneUser($user)
{
    if ($user->is('super.admin')) {
        $availableApps = Application::orderBy('name')->get();
    } else {
        $availableApps = $user->applications;
    }
    Session::put('availableApps', $availableApps);
    return $availableApps;
}

//TODO: now is only for the super admin, complete for all kind of users
/**Function to get all the available users
 * and put them in the session
 * @return mixed
 */
function availableUsers()
{
    $availableUsers = [];
    if (Auth::check() && Auth::user()->is('super.admin')) {
        $availableUsers = Session::get('currentApp')
            ->users()
            ->where('user_id', '<>', Auth::user()->id)
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
    return ModuleApplication::getModulesApp(Session::get('currentApp')->id)->get();
}

/**
 * check if user have a permission in a class
 * @param $type
 * @param $className
 * @return bool
 */
function checkIfUserHavePermissions($type, $className){
    return (Auth::user()->is('super.admin')
        || Auth::user()->is(Session::get('currentApp')->id.'.admin')
        || Auth::user()->can($type.'.'.Session::get('currentApp')->id.'.'.strtolower($className)));
}

/**
 * function to check if a user if valid for showing the add button in a specific class
 * @param $className
 * @return bool
 */
function checkIfUserIsValidForAddButton($className)
{
    return ($className === 'Application' && Auth::user()->is('super.admin'))
            || ($className !== 'Application' && (checkIfUserHavePermissions('create', $className)));
}

/**
 * function to check if a user if valid for showing the delete button in a specific class
 * @param $className
 * @return bool
 */
function checkIfUserIsValidForDeleteButton($className)
{
    return ($className === 'Application' && Auth::user()->is('super.admin'))
        || ($className !== 'Application' && (checkIfUserHavePermissions('delete', $className)));
}

