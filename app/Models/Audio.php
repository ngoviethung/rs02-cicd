<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use Request;
use App\Models\UserFavorite;
use App\Models\Creator;
use DB;

class Audio extends Model
{
    use CrudTrait;
    use RevisionableTrait;
    use ModelTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'audios';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'duration', 'thumb', 'mp3', 'short_description', 'description','lock', 'daily'];
    protected $hidden = ['created_at', 'updated_at', 'creator_id', 'playlist_id', 'album_id', 'topic_id', 'daily'];
    // protected $dates = [];
    protected $appends = ['is_favorite', 'type', 'creator'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getCreatorAttribute(){
        $creator = Creator::select('id', 'name', 'avatar')->find($this->creator_id);
        if(!$creator){
            $creator = [
                'id' => 0,
                'name' => 'Anonymous',
                'avatar' => url('/uploads/avatar/anonymous.jpg')
            ];
        }
        return $creator;
    }
    public function getTypeAttribute(){
        return 'audio';
    }
    public function getIsFavoriteAttribute(){
        $user_id = Request::get('user_id');
        $data = ['user_id' => $user_id, 'post_id' => $this->id, 'type' => 'audio'];
        $check = UserFavorite::where($data)->count();
        return $check;
    }
    public function getThumbAttribute($value){
        if (Request::is('api*')) {
            return $this->get_domain_cdn().'/'.$value;
        }
        return $value;
    }
    
     public function getMp3Attribute($value){
        if (Request::is('api*')) {
            return $this->get_domain_cdn().'/'.$value;
        }
        return $value;
    }
    
    
    public function setThumbAttribute($value)
    {
        $this->uploadFileToDisk($value, 'thumb', 'public', 'uploads/thumb');
        
    }
    public function setMp3Attribute($value)
    {
        $this->uploadFileToDisk($value, 'mp3', 'public', 'uploads/mp3');
    }
     
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    public function topic(){
        return $this->belongsTo('App\Models\Topic');
    }
    public function playlist(){
        return $this->belongsTo('App\Models\Playlist');
    }
    public function album(){
        return $this->belongsTo('App\Models\Album');
    }
    public function creator(){
        return $this->belongsTo('App\Models\Creator');
    }
    
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
