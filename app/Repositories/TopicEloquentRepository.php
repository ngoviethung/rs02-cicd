<?php
namespace App\Repositories;
use App\Repositories\Abstracts\EloquentRepository;
use App\Repositories\Contracts\TopicRepositoryInterface;
use App\Models\Topic;

class TopicEloquentRepository extends EloquentRepository implements TopicRepositoryInterface{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Topic::class;
    }
    public function getPostsByTopic($topic_id, $type){
        
        if($type == 'audio'){
            $data = Topic::with('audios')->find($topic_id);
            return $data->audios;
        }
        if($type == 'video'){
            $data = Topic::with('videos')->find($topic_id);
            return $data->videos;
        }
        if($type == 'playlist'){
            $data = Topic::with('playlists')->find($topic_id);
            return $data->videos;
        }
        if($type == 'album'){
            $data = Topic::with('albums')->find($topic_id);
            return $data->videos;
        }
        
        return [];
    }
}