<?php
namespace App\Repositories\Contracts;
interface VideoRepositoryInterface extends RepositoryInterface{
    
    public function checkVideoIsFavorite($user_id, $video_id);

    public function getVideos($tab, $type, $category_id = null);
    
    public function getVideo($tab, $type);
    
    public function getVideosByCategoryName($tab, $name);
    
    
    
    
}