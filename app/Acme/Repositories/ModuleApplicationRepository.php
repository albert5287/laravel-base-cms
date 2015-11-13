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
    function __construct(ModuleApplication $model){
        $this->model = $model;
    }

    public function getFirstForApp($appId){
        return $this->where('application_id', '=', $appId)->first();
    }
}