<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;



use App\Language;

class LanguageRepository extends DbRepository
{
    function __construct(Language $model){
        $this->model = $model;
    }
}