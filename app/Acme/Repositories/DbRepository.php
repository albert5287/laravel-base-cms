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
     * Find a model by its primary key or throw an exception.
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Save a new model and return the instance.
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a record in the database.
     * @param $entity
     * @param array $data
     * @return mixed
     */
    public function update($entity, array $data)
    {
        $entity->fill($data);
        $entity->save();
        return $entity;
    }

    /**
     * Delete a record from the database
     * @param $entity
     * @return mixed
     */
    public function delete($entity)
    {
        if (is_numeric($entity)) {
            $entity = $this->find($entity);
        }
        $entity->delete();
        return $entity;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')){
        return $this->model->all($columns);
    }

    /**
     * Add a basic where clause to the query.
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return mixed
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and'){
        return $this->model->where($column, $operator, $value, $boolean);
    }

    /**
     * Add an "order by" clause to the query.
     * @param $column
     * @param string $direction
     * @return mixed
     */
    public function orderBy($column, $direction = 'asc'){
        return $this->model->orderBy($column, $direction);
    }

    /**
     * Get an array with the values of a given column.
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function lists($column, $key = null){
        return $this->model->lists($column, $key);
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