<?php
 
namespace App\Http\Controllers\Api;
 
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Contracts\PlaylistRepositoryInterface;
use Exception;
class PlaylistController extends AppBaseController
{
    private $playlist;
    public function __construct(PlaylistRepositoryInterface $playlist){
        $this->playlist = $playlist;
    }
    public function audios(Request $request){
        try{

            $playlist_id = $request->playlist_id;
            if (!$playlist_id){
                throw new Exception("Missing paramter");
            }
            $data = $this->playlist->with(['audios'])->findBy(['id' => $playlist_id]);
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
        
    }

}