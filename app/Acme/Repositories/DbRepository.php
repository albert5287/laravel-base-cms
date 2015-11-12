<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 12:23
 */

namespace Acme\Repositories;


abstract class DbRepository
{
    protected $model;

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($entity, array $data)
    {
        $entity->fill($data);
        $entity->save();
        return $entity;
    }

    public function delete($entity)
    {
        if (is_numeric($entity)) {
            $entity = $this->findOrFail($entity);
        }
        $entity->delete();
        return $entity;
    }

    /**
     * function to insert or update a model in different languages
     * @param $entity
     * @param $newValues
     */
    public function insertUpdateMultiLanguage($entity, $newValues)
    {
        foreach ($newValues as $key => $value) {
            if (strpos($key, '_') !== 0) {
                if (is_array($value)) {
                    foreach ($value as $lang => $val) {
                        if ($val !== '') {
                            $entity->translateOrNew($lang)->$key = $val;
                        }
                    }
                } else {
                    $entity->$key = $value;
                }
            }
        }
        $entity->save();
    }
}