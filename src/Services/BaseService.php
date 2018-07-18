<?php

namespace AmtTmg\CRUD\services;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService
{

    /**
     * Get all Resource
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->latest()->paginate(10);
    }

    /**
     * Find by primary key
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }


    /**
     * Find by primary key with
     *
     * @param int $id
     * @return mixed
     */
    public function findWith(int $id, array $with)
    {
        return $this->model->with($with)->find($id);
    }

    /**
     * create
     *
     * @param $storeData
     * @return mixed
     */
    public function create(array $storeData)
    {
        return $this->model->create($storeData);
    }

    /**
     * update
     *
     * @param $updateData
     * @param $id
     * @return mixed
     */
    public function update(array $updateData, int $id)
    {
        $model = $this->find($id);

        $model->update($updateData);

        return $model;
    }

    /**
     * destroy
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        $model = $this->find($id);
        $model->delete($model);
    }
}
