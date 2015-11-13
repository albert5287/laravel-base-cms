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
}