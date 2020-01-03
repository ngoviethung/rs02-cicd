<?php
namespace App\Repositories;
use App\Repositories\Abstracts\EloquentRepository;
use App\Repositories\Contracts\VideoRepositoryInterface;
use App\Models\UserFavorite;
use Request;
use App\Models\User;

class VideoEloquentRepository extends EloquentRepository implements VideoRepositoryInterface{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Video::class;
    }
    
    public function getVideo($tab, $type){
        $video = [];
        if($type == 'random'){
            $video = $this->model::join('categories', 'videos.category_id', 'categories.id')
                     ->where('categories.type', $tab)
                     ->inRandomOrder()->select('videos.*')->first();
        }
        
        return $video;
    }
    public function getVideosByCategoryName($tab, $name){
        $videos = $this->model::join('categories', 'videos.category_id', 'categories.id')
            ->where('categories.type', $tab)->where('categories.name', $name)
            ->orderBy('videos.created_at', 'DESC')
            ->get(['videos.*']);
            
        return $videos;
    }
    public function getVideos($tab, $type, $category_id = null){
        $user_id = Request::get('user_id');
        $videos = [];
        
        if(($tab == 'sleep' or $tab == 'meditate') && $type == 'all'){
            $videos = $this->model::join('categories', 'videos.category_id', 'categories.id')
            ->where('categories.type', $tab)
            ->orderBy('videos.created_at', 'DESC')
            ->get(['videos.*']);
            
            
        }
        if(($tab == 'sleep' or $tab == 'meditate') && $type == 'favorite'){
            $videos = $this->model::join('users_favorites', 'videos.id', 'users_favorites.video_id')
            ->where('users_favorites.user_id', $user_id)
            ->join('categories', 'videos.category_id', 'categories.id')
            ->where('categories.type', $tab)
            ->orderBy('videos.created_at', 'DESC')
            ->get(['videos.*']);
        }
        
        if($tab == 'sleep' && $type == 'recommended'){
            $purpose = User::find(177);
            $purpose = $purpose->purpose;
            $purpose = explode(',', $purpose);
            
            $query = $this->model::join('categories', 'videos.category_id', 'categories.id')
            ->where('categories.type', $tab)
            ->where(function($query) use ($purpose){
                 foreach($purpose as $val){
                    $query->orWhere('videos.tags', 'LIKE', '%'.trim($val).'%');
                 }
            });
            $videos = $query->inRandomOrder('videos.created_at')
            ->get(['videos.*']);
        }
        if($tab == 'body' && $type == 'all'){
            $videos = $this->model::join('categories', 'videos.category_id', 'categories.id')
            ->where('categories.type', $tab)
            ->orderBy('videos.created_at', 'DESC')
            ->get(['videos.*']);
        }
        
        if($tab == 'body' && $type == 'favorite'){
            
            $videos = $this->model::join('users_favorites', 'videos.id', 'users_favorites.video_id')
            ->where('users_favorites.user_id', $user_id)
            ->join('categories', 'videos.category_id', 'categories.id')
            ->where('categories.type', $tab)
            ->orderBy('videos.created_at', 'DESC')
            ->get(['videos.*']);
        }
        
        if($category_id){
             $videos = $this->model::where('category_id', $category_id)->get();
        }
        
        return $videos;
    }
    
    
    
    public function checkVideoIsFavorite($user_id, $video_id){
        $data = ['user_id' => $user_id, 'video_id' => $video_id];
        $check = UserFavorite::where($data)->count();
        
        return $check;
        
    }
    
}