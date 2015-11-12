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
    function __construct(Application $model){
        $this->model = $model;
    }

    /**
     * @param $application
     * @param $data
     */
    public function insertUpdateApplication($application, $data){
        $this->insertUpdateMultiLanguage($application, $data->all());
        $modulesToSync = null !== $data->input('_modules') ? $data->input('_modules') : [];
        $this->insertUpdateAvailableModules($application, $modulesToSync);
    }

    public function attachRoles($application, $roles){
        $application->roles()->attach($roles);
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