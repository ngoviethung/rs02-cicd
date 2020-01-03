<?php
namespace App\Repositories;
use App\Repositories\Abstracts\EloquentRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\User;
class CategoryEloquentRepository extends EloquentRepository implements CategoryRepositoryInterface{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Category::class;
    }
    
    
}