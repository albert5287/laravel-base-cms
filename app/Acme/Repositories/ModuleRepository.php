<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 12:25
 */

namespace Acme\Repositories;

use App\Module;

class ModuleRepository extends DbRepository
{
    function __construct(Module $model){
        $this->model = $model;
    }

    public function getListActiveContentModules(){
        return $this->model
            ->activeContentModules()
            ->get()
            ->lists('title', 'id');
    }
}