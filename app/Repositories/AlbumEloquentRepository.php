<?php
namespace App\Repositories;
use App\Repositories\Abstracts\EloquentRepository;
use App\Repositories\Contracts\AlbumRepositoryInterface;

class AlbumEloquentRepository extends EloquentRepository implements AlbumRepositoryInterface{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Album::class;
    }
}