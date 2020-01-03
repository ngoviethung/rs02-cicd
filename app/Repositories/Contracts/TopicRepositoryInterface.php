<?php
namespace App\Repositories\Contracts;
interface TopicRepositoryInterface extends RepositoryInterface{
    
    public function getPostsByTopic($topic_id, $type);
}