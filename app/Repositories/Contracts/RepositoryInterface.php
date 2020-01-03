<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function whereLike($column, $keyword, array $columns = ['*']);
    
    public function whereNotIn($column, array $conditions, array $columns = ['*']);
    
	public function all(array $columns = ['*']);

	public function paginate(int $perPage = 15, array $columns = ['*']);

	public function paginateBy(array $conditions, int $perPage = 15, int $offset = null, array $columns = ['*']);

	public function paginateByWithOrder(array $conditions , string $orderField, string $orderType, int $perPage = 15, int $offset = null, array $columns = ['*']);

	public function count();

	public function countBy(array $conditions);

	public function find($id, array $columns = ['*']);

	public function findBy(array $conditions, array $columns = ['*']);

	public function findManyBy(array $conditions, array $columns = ['*']);

	public function findManyByWithOrder(array $conditions, string $orderField, string $orderType, array $columns = ['*']);
    
    public function findManyByWithOrderRaw(array $conditions, string $ids_ordered, array $columns = ['*']);

	public function findForUpdate(array $conditions);

    public function findManyForUpdate(array $conditions);

    public function findManyForUpdateWithOrder(array $conditions, string $orderField, string $orderType);

	public function join(array $option);

	public function create(array $attributes);
    
    public function insertGetId(array $attributes);
    
	public function insertOrUpdateBatch($records, array $exclude = []);

	public function update($id, array $attributes);

	public function updateBy(array $conditions, array $attributes);

	public function delete($id);

	public function deleteBy(array $conditions);

	public function with($relations);
}