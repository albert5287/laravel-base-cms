<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;


use App\Company;

class CompanyRepository extends DbRepository
{
    function __construct(Company $model){
        $this->model = $model;
    }

    public function getCompanyList($column = 'name', $key = 'id'){
        return ['' => ''] + $this->lists($column, $key)->all();
    }
}