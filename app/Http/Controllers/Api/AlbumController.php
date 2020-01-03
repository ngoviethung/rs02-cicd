<?php
 
namespace App\Http\Controllers\Api;
 
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Contracts\AlbumRepositoryInterface;
use Exception;
class AlbumController extends AppBaseController
{
    private $album;
    public function __construct(AlbumRepositoryInterface $album){
        $this->album = $album;
    }
    public function audios(Request $request){
        try{

            $album_id = $request->album_id;
            if (!$album_id){
                throw new Exception("Missing paramter");
            }
            $data = $this->album->with(['audios'])->findBy(['id' => $album_id]);
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
        
    }

}