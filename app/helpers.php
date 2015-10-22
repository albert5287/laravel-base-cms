<?php
use App\Application;
use App\Language;
use App\Module;
use App\ModuleApplication;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 29.09.2015
 * Time: 16:35
 */

//TODO
//filter by active languages
//maybe change to the model
function getActiveLanguages(){
    return Language::withTranslation()->get();
}
//TODO
//filter by active Modules
//maybe change to the model
/**
 * @return mixed
 */
function getAvailableModulesForAUser($user){
    $modules = Module::where('enabled', '=', true)
        ->where('show_sidebar', '=', true);
    if(!($user->is('super.admin'))){
        $modules->where('only_super_admin', '=', false);
    }
    return $modules->withTranslation()->get();
}

function getAllActiveModules(){
    return Module::where('enabled', '=', true)->withTranslation()->get();
}

//TODO: maybe change this to a base model and extend that model
function insertUpdateMultiLanguage($element, $newValues){
    foreach($newValues as $key => $value){
        if(strpos($key, '_') !== 0){
            if(is_array($value)){
                foreach($value as $lang => $val){
                    if($val !== ''){
                        $element->translateOrNew($lang)->$key = $val;
                    }
                }
            }
            else{
                $element->$key = $value;
            }
        }
    }
    $element->save();
}

function getAvailableApps(){
    if(Session::has('availableApps')){
        return Session::get('availableApps');
    }
    else{
        return getAvailableAppsForOneUser();
    }
}

function getAvailableUsers(){
    if(Session::has('availableUsers')){
        return Session::get('availableUsers');
    }
    else{
        return availableUsers();
    }
}

//TODO: now is only for the super admin, complete for all kind of users
/**Function to get all the available app for a user
 * and put them in the session
 * @return mixed
 */
function getAvailableAppsForOneUser(){
    if(Auth::check() && Auth::user()->is('super.admin')){
        $availableApps = Application::orderBy('name')->get();
        Session::put('availableApps', $availableApps);
        return $availableApps;
    }
}

//TODO: now is only for the super admin, complete for all kind of users
/**Function to get all the available users
 * and put them in the session
 * @return mixed
 */
function availableUsers(){
    if(Auth::check() && Auth::user()->is('super.admin')){
        $availableUsers = User::where('id', '<>', Auth::user()->id)->get();
        Session::put('availableUsers', $availableUsers);
        return $availableUsers;
    }
}

function getContentModulesForCurrentApp(){
    return ModuleApplication::getModulesApp(Session::get('currentApp')->id)->get();
}