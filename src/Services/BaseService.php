<?php

namespace App\Services\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseService
 * @package App\Http\Services
 */
abstract class BaseService
{
    /**
     * @var Builder|Model
     */
    protected $model;

    /**
     * BaseService constructor.
     */
    public function __construct()
    {
        $this->model = $this->model();
    }

    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function all($columns=['*'])
    {
        return $this->model->all( is_array($columns) ? $columns : func_get_args());
    }

    /**
     * @param string $value
     * @param string $key
     * @return \Illuminate\Support\Collection
     */
    public function allForDropDown($value = 'name', $key = 'id')
    {
        return $this->all()->pluck($value, $key);
    }

    /**
     * @param $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Model|mixed
     */
    public function firstOrNew(array $attributes, array $values = [])
    {
        return $this->model->firstOrNew($attributes, $values);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Model|mixed
     */
    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->model->firstOrCreate($attributes, $values);
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $where array|integer|Model
     * @param $data
     * @return bool|int
     */
    public function update($where, $data)
    {
        if ($where instanceof Model) {
            return $where->update($data);
        }

        if (is_array($where)) {
            return $this->model->where($where)->update($data);
        }

        return $this->model->findOrFail($where)->update($data);

    }

    /**
     * Update Or Create
     *
     * @param $where
     * @param $data
     * @return Model
     */
    public function updateOrCreate($where, $data)
    {
        return $this->model->updateOrCreate($where, $data);
    }

    /**
     * @param $ids array|int
     * @return bool|int
     */
    public function destroy($ids)
    {
        return $this->model->destroy($ids);
    }

    /**
     * Delete all
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function truncate()
    {
        return $this->model->truncate();
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        return $this->model->insert($data);
    }

    /**
     * @return Model
     */
    abstract public function model();
}
