<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;

use App\Application;

class ApplicationRepository extends DbRepository
{
    function __construct(Application $model)
    {
        $this->model = $model;
    }

    /**
     * @param $application
     * @param $data
     */
    public function insertUpdateApplication($application, $data)
    {
        $this->insertUpdateMultiLanguage($application, $data->all());
        $modulesToSync = null !== $data->input('_modules') ? $data->input('_modules') : [];
        $this->insertUpdateAvailableModules($application, $modulesToSync);
    }

    /**
     * function to attach roles to an application
     * @param $application
     * @param $roles
     */
    public function attachRoles($application, $roles)
    {
        $application->roles()->attach($roles);
    }

    /**
     * Get the roles of an app
     * @param $application
     * @return mixed
     */
    public function getRoles($application)
    {
        return $application->roles()
            ->where('slug', '<>', $application->id . '.admin')
            ->get();
    }

    /**
     * get users of an application
     * @param $application
     * @return mixed
     */
    public function getUsers($application){
        return $application->users()->get();
    }

    /**
     * @param $application
     * @param $modules
     */
    private function insertUpdateAvailableModules($application, $modules)
    {
        $application->availableModules()->sync($modules);
    }
}