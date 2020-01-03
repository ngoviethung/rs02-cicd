<?php
namespace App\Repositories;
use App\Repositories\Abstracts\EloquentRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\UserFavorite;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\User::class;
    }
    
    public function getPostFavorite($user_id, array $columns = ['*'], string $orderField, string $orderType = 'ASC'){
        
        $data = UserFavorite::where('user_id', $user_id)->orderBy($orderField, $orderType)->get($columns);
        return $data;
    }
    public function RemoveFromFavorite($user_id, $post_id, $type){
        
        $data = ['user_id' => $user_id, 'post_id' => $post_id, 'type' => $type];
        $check = $this->checkPostIsFavorite($user_id, $post_id, $type);
        if($check > 0){
            UserFavorite::where($data)->delete();
        }
        return;
        
    }
    public function addToFavorite($user_id, $post_id, $type){
        
        $data = ['user_id' => $user_id, 'post_id' => $post_id, 'type' => $type];
        $check = $this->checkPostIsFavorite($user_id, $post_id, $type);
        if($check == 0){
            UserFavorite::insert($data);
        }
        return;
        
    }
    
    private function checkPostIsFavorite($user_id, $post_id, $type){
        $data = ['user_id' => $user_id, 'post_id' => $post_id, 'type' => $type];
        $check = UserFavorite::where($data)->count();
        
        return $check;
        
    }
}