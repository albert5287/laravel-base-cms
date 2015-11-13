<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;

use App\ModuleApplication;

class ModuleApplicationRepository extends DbRepository
{
    /**
     * @param ModuleApplication $model
     */
    function __construct(ModuleApplication $model){
        $this->model = $model;
    }

    /**
     * @param $appId
     * @return mixed
     */
    public function getFirstForApp($appId){
        return $this->where('application_id', '=', $appId)->first();
    }

    /**
     * @param $app
     * @return array
     */
    public function getListAvailableContentModules($app)
    {
        $list = $app->availableModules()
            ->get()
            ->lists('title', 'id')
            ->all();
        return ['' => ''] + $list;
    }
}