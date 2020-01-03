<?php
namespace App\Repositories;
use App\Repositories\Abstracts\EloquentRepository;
use App\Repositories\Contracts\CreatorRepositoryInterface;

class CreatorEloquentRepository extends EloquentRepository implements CreatorRepositoryInterface{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Creator::class;
    }
}