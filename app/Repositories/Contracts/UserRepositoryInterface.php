<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface extends RepositoryInterface{
    
    public function addToFavorite($user_id, $post_id, $type);

    public function RemoveFromFavorite($user_id, $post_id, $type);
    
    public function getPostFavorite($user_id, array $columns = ['*'], string $orderField, string $orderType);
    
}