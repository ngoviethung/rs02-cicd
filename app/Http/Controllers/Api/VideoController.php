<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Contracts\VideoRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Theme;
use Exception;
class VideoController extends AppBaseController
{
    private $video;
    public function __construct(VideoRepositoryInterface $video){
        $this->video = $video;
    }

    
    
}