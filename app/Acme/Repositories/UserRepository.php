<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;



use App\User;

class UserRepository extends DbRepository
{
    function __construct(User $model){
        $this->model = $model;
    }

    /**
     * Function to get a list with the available roles
     * @param $application
     * @param $user
     * @return mixed
     */
    public function getListRolesToAssign($application, $user){
        return $application->roles()
            ->where('level', '<=', $user->level())
            ->get()
            ->lists('name', 'id');
    }

    /**
     * function to attach a user to an application
     * @param $user
     * @param $appId
     */
    public function attachToApplication($user, $appId){
        $user->applications()->attach($appId);
    }

    /**
     * function to detach a user from an application
     * @param $user
     * @param $appId
     */
    public function detachFromApplication($user, $appId){
        $user->applications()->detach($appId);
    }

    /**
     * function to get an array with the app's id that the user is linked to
     * @param $user
     * @param $appId
     * @param string $operator
     * @return mixed
     */
    public function getArrayListRolesByApp($user, $appId, $operator = '='){
        return $user
            ->getRolesByApp($appId, $operator)
            ->lists('id')
            ->toArray();
    }

    /**
     * sync user's role
     * @param $user
     * @param $oldRoles
     * @param $newRoles
     */
    public function syncRoles($user, $oldRoles, $newRoles ){
        //merge user's role from other with the one selected in this app
        $roles = array_merge($oldRoles, $newRoles);
        //sync user's roles
        $user->roles()->sync($roles);
    }

    /**
     * detach roles from a user
     * @param $user
     * @param $roles
     */
    public function detachRoles($user, $roles){
        foreach ($roles as $role) {
            $user->detachRole($role);
        }
    }

    /**
     * function to remove roles from app, and unlink user to the app
     * @param $user
     * @param $app_id
     */
    public function unlinkFromApp($user, $app_id){
        //get user's roles from app
        $userRoles = $this->getArrayListRolesByApp($user, $app_id);
        //remove those roles from the user
        $this->detachRoles($user, $userRoles);
        //remove link between user an app
        $this->detachFromApplication($user, $app_id);
    }

    /**
     * get other application of the user
     * @param $user
     * @param $app_id
     * @return mixed
     */
    public function getOtherApplications($user, $app_id){
        return $user
            ->applications()
            ->where('application_id', '<>', $app_id)
            ->get();
    }
}