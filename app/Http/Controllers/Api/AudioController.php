<?php
 
namespace App\Http\Controllers\Api;
 
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Contracts\AudioRepositoryInterface;
use Exception;
class AudioController extends AppBaseController
{
    private $audio;
    public function __construct(AudioRepositoryInterface $audio){
        $this->audio = $audio;
    }

    public function audios(Request $request){
        try{
            
            $audios = $this->audio->paginate(20, ['*']);
            $response = [
                'code' => 200,
                'message' => 'sucsess',
                'next_page_url' => $audios->nextPageUrl() ? : '',
                'data' => $audios->items()
            ];
            return json_encode($response);
        }catch(exception $e){
            return $this->sendError($e->getMessage());
        }
    }

}