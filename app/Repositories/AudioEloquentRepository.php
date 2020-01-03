<?php
namespace App\Repositories;
use App\Repositories\Abstracts\EloquentRepository;
use App\Repositories\Contracts\AudioRepositoryInterface;

class AudioEloquentRepository extends EloquentRepository implements AudioRepositoryInterface{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Audio::class;
    }
}