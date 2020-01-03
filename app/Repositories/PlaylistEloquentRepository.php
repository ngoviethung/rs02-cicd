<?php
namespace App\Repositories;
use App\Repositories\Abstracts\EloquentRepository;
use App\Repositories\Contracts\PlaylistRepositoryInterface;

class PlaylistEloquentRepository extends EloquentRepository implements PlaylistRepositoryInterface{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Playlist::class;
    }
}