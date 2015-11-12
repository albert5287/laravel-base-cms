<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;


use Bican\Roles\Models\Role;

class RoleRepository extends DbRepository
{
    function __construct(Role $model){
        $this->model = $model;
    }
}