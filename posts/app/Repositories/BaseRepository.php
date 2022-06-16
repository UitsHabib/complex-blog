<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $modelName;

    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Instantiate Model
     *
     * @throws \Exception
     */
    public function setModel()
    {
        //check if the class exists
        if (class_exists($this->modelName)) {
            $this->model = new $this->modelName();

            //check object is a instanceof Illuminate\Database\Eloquent\Model
            if (!$this->model instanceof Model) {
                throw new \Exception("{$this->modelName} must be an instance of Illuminate\Database\Eloquent\Model");
            }
        } else {
            throw new \Exception('No model name defined');
        }
    }

    /**
     * Get Model instance
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }


    public function findOrFail($id, $relation = null, array $orderBy = null)
    {
        return $this->prepareModelForRelationAndOrder($relation, $orderBy)->findOrFail($id);
    }

    /**
     * Find a resource by criteria
     *
     * @param array $criteria
     * @param null $relation
     * @return Model|null
     */
    public function findOneBy(array $criteria, $relation = null)
    {
        return $this->prepareModelForRelationAndOrder($relation)->where($criteria)->first();
    }

    /**
     * Find a resource by criteria or create new
     *
     * @param array $criteria
     * @param array $dataToSave
     * @param null $relation
     * @return Model|null
     */    
    public function findOneByOrCreate(array $criteria, array $dataToSave = null, $relation = null) 
    {
        return $this->findOneBy($criteria, $relation)
            ?? $this->save($dataToSave);  
    }

    /**
     * Retrieve all resources
     *
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getAll()
    {
        return $this->model->get();
    }

    public function getWith(array $criteria, array $relation) 
    {
        return $this->prepareModelForRelationAndOrder($relation)->where($criteria)->get();
    }

    /**
     * Save a resource
     *
     * @param array $data
     * @return Model
     */
    public function save(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update resource
     *
     * @param $resource
     * @param $data
     * @return \Illuminate\Support\Collection|null|static
     */
    public function update($resource, $data = [])
    {
        if (is_array($data) && count($data) > 0) {
            $resource->fill($data);
        }

        // $this->save($resource);
        $resource->save();

        return $resource;
    }

    /**
     * Delete resource
     *
     * @param $resource
     * @return \Illuminate\Support\Collection|null|static
     */
    public function delete($resource)
    {
        $resource->delete();

        return $resource;
    }

    /**
     * @param $relation
     * @param array|null $orderBy [[Column], [Direction]]
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    private function prepareModelForRelationAndOrder($relation, array $orderBy = null)
    {
        $model = $this->model;
        if ($relation) {
            $model = $model->with($relation);
        }
        if ($orderBy) {
            $model = $model->orderBy($orderBy['column'], $orderBy['direction']);
        }
        return $model;
    }
}
