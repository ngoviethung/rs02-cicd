<?php
 
namespace App\Http\Controllers\Api;
 
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Contracts\TopicRepositoryInterface;
use Exception;
class TopicController extends AppBaseController
{
    private $topic;
    public function __construct(TopicRepositoryInterface $topic){
        $this->topic = $topic;
    }

}
