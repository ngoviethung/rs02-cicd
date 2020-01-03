<?php
 
namespace App\Http\Controllers\Api;
 
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\AudioRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TopicRepositoryInterface;
use App\Repositories\Contracts\AlbumRepositoryInterface;
use App\Repositories\Contracts\PlaylistRepositoryInterface;
use App\Repositories\Contracts\VideoRepositoryInterface;
use Exception;

class CategoryController extends AppBaseController
{
    private $category;
    private $audio;
    private $user;
    private $topic;
    private $video;
    private $album;
    private $playlist;
    
    
    
    public function __construct(CategoryRepositoryInterface $category, AudioRepositoryInterface
                    $audio, UserRepositoryInterface $user, TopicRepositoryInterface $topic,
                    VideoRepositoryInterface $video, AlbumRepositoryInterface $album,
                    PlaylistRepositoryInterface $playlist){
                        
        $this->category = $category;
        $this->audio = $audio;
        $this->user = $user;
        $this->topic = $topic;
        $this->video = $video;
        $this->album = $album;
        $this->playlist = $playlist;
        
    }
    
    private function __getFavoriteByUser($user_id){
        $favorites = $this->user->getPostFavorite($user_id, ['*'], 'created_at', 'DESC');
        $data = [];
        if(!$favorites->isEmpty()){
                foreach($favorites as $favorite){
                    if($favorite->type == 'audio'){
                        $data[] = $this->audio->find($favorite->post_id);
                    }elseif($favorite->type == 'video'){
                        $data[] = $this->video->find($favorite->post_id);
                        
                    }elseif($favorite->type == 'playlist'){
                        $data[] = $this->playlist->find($favorite->post_id);
                        
                    }elseif($favorite->type == 'album'){
                        $data[] = $this->album->find($favorite->post_id);
                        
                    }else{
                        
                    }
                }
        }
        return $data;
    }
    private function __getPostsByCategory($purpose){
        
        $data = [];
        $ids_ordered = implode(',', $purpose);
        $categories = $this->category->with(['audios', 'playlists', 'albums', 'videos'])->findManyByWithOrderRaw(['id' => $purpose], $ids_ordered, ['*']);
        
        foreach($categories as $category){
            
            $audios = $category->audios;
            $videos = $category->videos;
            $playlists = $category->playlists;
            $albums = $category->albums;
            
            foreach($audios as $audio){
                $audio->type = 'audio';
                $data[] = $audio;
            }
            foreach($videos as $video){
                $video->type = 'video';
                $data[] = $video;
            }
            foreach($playlists as $playlist){
                $playlist->type = 'playlist';
                $data[] = $playlist;
            }
            foreach($albums as $album){
                $album->type = 'album';
                $data[] = $album;
            }
            unset($category->audios);
            unset($category->videos);
            unset($category->playlists);
            unset($category->albums);            
            $category->items = $data;
            
        }
        
        return $categories;
    }
    private function __getPostsStarted(){
        $data = [];
        $categories = $this->category->with(['audios', 'playlists', 'albums', 'videos'])->findManyBy(['name' => 'Getting Started']);
        
        foreach($categories as $category){
            
            $audios = $category->audios;
            $videos = $category->videos;
            $playlists = $category->playlists;
            $albums = $category->albums;
            
            foreach($audios as $audio){
                $audio->type = 'audio';
                $data[] = $audio;
            }
            foreach($videos as $video){
                $video->type = 'video';
                $data[] = $video;
            }
            foreach($playlists as $playlist){
                $playlist->type = 'playlist';
                $data[] = $playlist;
            }
            foreach($albums as $album){
                $album->type = 'album';
                $data[] = $album;
            }
        }
        
        return $data;
    }
    public function home(Request $request){
        try{
            $user_id = $request->get('user_id');
            
            $daily = $this->audio->findBy(['daily' => 1], ['*']);
            if(!$daily){
                $daily = $this->audio->findBy([], ['*']);
            }
            
            $purpose_of_user = $this->user->find($user_id, ['purpose']);
            $purpose = json_decode($purpose_of_user->purpose);
            
            if($purpose == ''){
                $arr_cate_id = $this->category->paginate(10, ['id']);
                $purpose = [];
                foreach($arr_cate_id as $val){
                    $purpose[] = $val->id;
                }
            }
            
            $getting_started = $this->__getPostsStarted();
            $categories = $this->__getPostsByCategory($purpose);
            $favorites = $this->__getFavoriteByUser($user_id);
            
            $data['daily'] = $daily;
            $data['getting_started'] = $getting_started;
            $data['favorite'] = $favorites;
            $data['categories'] = $categories;
            
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function recommendation(Request $request){
        try{
            $type = $request->type;
            $id = $request->id;
            if (!$type or !$id){
                throw new Exception('Mising paramter');
            }
            if($type == 'audio'){
                $audio = $this->audio->find($id,['category_id']);
                $category_id = $audio->category_id;
                $data = $this->audio->paginateBy(['category_id' => $category_id, 'id' => ['!=', $id]], 5);
                
            }
            if($type == 'video'){
                $video = $this->video->find($id,['category_id']);
                $category_id = $video->category_id;
                $data = $this->video->paginateBy(['category_id' => $category_id, 'id' => ['!=', $id]], 5);
            }
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function search(Request $request){
        try{
            $keyword = $request->keyword;
            $tab = $request->tab;
            if (!$tab){
                throw new Exception('Mising paramter');
            }
            $data = [];
            
            if($tab == 'audios'){
                if($keyword != ''){
                    $data = $this->audio->whereLike('name', $keyword);
                }else{
                    $data = $this->audio->paginate(20);
                }
            }elseif($tab == 'videos'){
                if($keyword != ''){
                    $data = $this->video->whereLike('name', $keyword);
                }else{
                    $data = $this->video->paginate(20);
                }
            }elseif($tab == 'playlists'){
                if($keyword != ''){
                    $data = $this->playlist->whereLike('name', $keyword);
                }else{
                    $data = $this->playlist->paginate(20);
                }
            }elseif($tab == 'albums'){
                if($keyword != ''){
                    $data = $this->album->whereLike('name', $keyword);
                }else{
                    $data = $this->album->paginate(20);
                }
            }else{
                
            }
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    
    
    public function getPersonnalize(Request $request){
        try{
            $user_id = $request->get('user_id');
            
            $purpose_of_user = $this->user->find($user_id, ['purpose']);
            $purpose = json_decode($purpose_of_user->purpose);
            $added = [];
            $suggest = [];
            if($purpose){
                $ids_ordered = implode(',', $purpose);
                $added = $this->category->findManyByWithOrderRaw(['id' => $purpose], $ids_ordered, ['id', 'name']);
                $suggest = $this->category->whereNotIn('id', $purpose, ['id', 'name']);
                foreach($suggest as $key => $val){
                    if($val->name == 'Getting Started'){
                        unset($suggest[$key]);
                    }
                }
             $suggest = array_values($suggest->toArray()); 
            }else{
                $suggest = $this->category->findManyBy(['name' => ['!=','Getting Started']], ['id', 'name']);
            }
            $data = [
                'added' => $added,
                'suggest' => $suggest
            ];
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function updatePersonnalize(Request $request){
        try{
            
            return $this->sendResponse($categories);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function getCategoriesSuggest(Request $request){
        try{
            
            $categories = $this->category->paginateBy(['name' => ['!=','Getting Started']], 15, 0, ['id', 'name']);
            
            return $this->sendResponse($categories);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function categories(Request $request)
    {
        try{

            $tab = $request->tab;
            if (!$tab){
                throw new Exception("Missing tab");
            }
            $categories = $this->category->findManyBy(['tab' => $tab]);
     
            return $this->sendResponse($categories);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    
    
    public function getPostsByCategory(Request $request)
    {
        try{
            
            $id = $request->id;
            if (!$id){
                throw new Exception('Mising id');
            }
            $data = $this->category->with(['topics'])->findBy(['id' => $id]);
            
            foreach($data->topics as $topic){
                $topic->posts = $this->topic->getPostsByTopic($topic->id, $topic->type);
            }
        
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }

}