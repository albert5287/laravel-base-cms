<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;



use Bican\Roles\Models\Permission;

class PermissionRepository extends DbRepository
{
    function __construct(Permission $model){
        $this->model = $model;
    }
}