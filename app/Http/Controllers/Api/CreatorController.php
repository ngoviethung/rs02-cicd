<?php
 
namespace App\Http\Controllers\Api;
 
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Contracts\CreatorRepositoryInterface;
use Exception;
class CreatorController extends AppBaseController
{
    private $creator;
    public function __construct(CreatorRepositoryInterface $creator){
        $this->creator = $creator;
    }
    
    public function creator(Request $request){
        try
        {
            $id = $request->id;
            if (!$id){
                throw new Exception('Missing paramter');
            }
            $data = $this->creator->with(['playlists', 'audios'])->findBy(['id' => $id]);
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    public function creators(Request $request){
        try
        {
            $data = $this->creator->with(['playlists', 'audios'])->findManyBy([]);
            
            return $this->sendResponse($data);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }

}