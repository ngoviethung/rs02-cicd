<?php

namespace App\Repositories\Abstracts;

use App\Repositories\Contracts\RepositoryInterface;
use DB;

abstract class EloquentRepository implements RepositoryInterface
{
	/**
	 * @var \Illuminate\Database\Eloquent\Model
	 */
	protected $model;

	private $with;

	private $conditionWith = false;

	private $join;

	public function __construct()
	{
		$this->setModel();
	}

	/**
	 * get model
	 * @return string
	 */
	abstract public function getModel();

	/**
	 * Set model
	 */
	private function setModel()
	{
		$this->model = app()->make(
			$this->getModel()
		);
	}
    
    public function whereLike($column, $keyword, array $columns = ['*']){
        return $this->model->where($column, 'LIKE', "%$keyword%")->get($columns);
    }
    
    public function whereNotIn($column, array $conditions, array $columns = ['*']){
        
        return $this->model->whereNotIn($column, $conditions)->get($columns);
    }
    
	public function all(array $columns = ['*'])
	{
	  
		return $this->model->all($columns);
	}
    
    
	public function paginate(int $perPage = 15, array $columns = ['*'])
	{
		return $this->model->paginate($perPage, $columns);
	}

	public function paginateBy(array $conditions, int $perPage = 15, int $offset = null, array $columns = ['*'])
	{
		return $this->filter($conditions)->paginate($perPage, $columns, 'page', $offset);
	}

    public function paginateByWithOrder(array $conditions , string $orderField, string $orderType = 'ASC', int $perPage = 15,  int $offset = null, array $columns = ['*'])
    {
        return $this->filter($conditions)->orderBy($orderField, $orderType)->paginate($perPage, $columns, 'page', $offset);
        }

	public function count()
	{
		return $this->model->count();
	}

	public function countBy(array $conditions)
	{
		return $this->filter($conditions)->count();
	}

	public function find($id, array $columns = ['*'])
	{
		return $this->model->find($id, $columns);
	}

	public function findBy(array $conditions, array $columns = ['*'])
	{
		return $this->filter($conditions)->first($columns);
	}

	public function findManyBy(array $conditions, array $columns = ['*'])
	{
		return $this->filter($conditions)->get($columns);
	}

    public function findManyByWithOrder(array $conditions, string $orderField, string $orderType, array $columns = ['*'])
    {
        return $this->filter($conditions)->orderBy($orderField, $orderType)->get($columns);
    }
    
    public function findManyByWithOrderRaw(array $conditions, string $ids_ordered, array $columns = ['*'])
    {
        return $this->filter($conditions)->orderByRaw(DB::raw("FIELD(id, $ids_ordered)"))->get($columns);
    }

	public function findForUpdate(array $conditions)
	{
		return $this->filter($conditions)->lockForUpdate()->first();
	}

    public function findManyForUpdate(array $conditions)
    {
        return $this->filter($conditions)->lockForUpdate()->get();
    }

    public function findManyForUpdateWithOrder(array $conditions, string $orderField, string $orderType)
    {
        return $this->filter($conditions)->lockForUpdate()->orderBy($orderField, $orderType)->get();
    }

	public function create(array $attributes)
	{
		return $this->model->create($attributes);
	}
    
   	public function insert(array $attributes)
	{
		return $this->model->insert($attributes);
	}
    
    public function insertGetId(array $attributes){
        return $this->model->insertGetId($attributes);
    }

	public function update($id, array $attributes)
	{
		return $this->model->where($this->model->getKeyName(), $id)->update($attributes);
	}

	public function updateBy(array $conditions, array $attributes)
	{
		return $this->filter($conditions)->update($attributes);
	}

	public function delete($id)
	{
		return $this->model->destroy($id);
	}

	public function deleteBy(array $conditions)
	{
		return $this->filter($conditions)->delete();
	}

	public function join(array $option)
	{
		$this->join = $option;

		return $this;
	}

	public function insertOrUpdateBatch($records, array $exclude = [])
	{
		$columnsString = $valuesString = $updateString = '';
		$params = [];
		$size   = count($records);

		for ($i = 0; $i < $size; $i++) {
			$row = (array)$records[$i];
			if ($i == 0) {
				foreach ($row as $key => $value) {
					$columnsString .= "$key,";
					$updateString .= "$key=VALUES($key),";
				}
				$columnsString = rtrim($columnsString, ',');
				$updateString = rtrim($updateString, ',');
			} else {
				$valuesString .= ',';
			}

			$valuesString .= '(';

			foreach ($row as $key => $value) {
				$valuesString .= '?,';
				if (isset($value)) {
					$value = 'other';
				}
				array_push($params, $value);
			}

			$valuesString = rtrim($valuesString, ',');
			$valuesString .= ')';
		}

		$query = "INSERT INTO {$this->model->getTable()} ({$columnsString}) VALUES $valuesString ON duplicate KEY UPDATE $updateString";

		return $this->model->getConnection()->statement($query, $params);
	}
    
    //public function with($relations)
//    {
//        $this->model = $this->model->with($relations);
//        return $this;
//    }
    
    
	public function with($relations, $conditions = [])
    {
	    if (!empty($conditions)) {
		    $query = '';
		    $this->preFilterWhereIn($query, $conditions);
		    $this->conditionWith = $conditions;
	    }

        if (is_string($relations)) {
            $this->with = explode(',', $relations);

            return $this;
        }
        
        $this->with = is_array($relations) ? $relations : [];
        
        
        return $this;
    }
    
    
    protected function filter(array $conditions)
    {
        $instance = $this->getInstance();

        $query = $instance->whereNotNull($this->model->getTable() . '.' . $this->model->getKeyName());
        if (!empty($conditions)) {
            $this->preFilterWhereIn($query, $conditions);
            $query->where($conditions);
        }

        return $query;
    }

    private function getInstance()
    {
        $instance = $this->model;

        if ($this->with) {
            $instance = $this->model::with($this->with);
        }

        if ($this->conditionWith) {
        	$instance = $instance->where($this->conditionWith);
        	$this->conditionWith = false;
        }

        if ($this->join) {
	        if ($this->join['type'] == 'LEFT') {
		        return $this->model->leftJoin($this->join['table'], $this->join['field1'], '=', $this->join['field2']);
	        } else {
		        return $this->model->join($this->join['table'], $this->join['field1'], '=', $this->join['field2']);
	        }
        }

        return $instance;
    }

    private function preFilterWhereIn($query, &$conditions)
    {
        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                if (is_string($key)) {
                    if (in_array($value['0'], ['>=', '<=', '>', '<', '<>', '!='])) {
                        $query->where($key, $value['0'], $value['1']);
                    } else {
                        $query->whereIn($key, $value);
                    }

                    unset($conditions[$key]);
                }
            }
        }
    }
}