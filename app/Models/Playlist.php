<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use Request;
use App\Models\UserFavorite;
use App\Models\Audio;
use App\Models\Creator;
class Playlist extends Model
{
    use CrudTrait;
    use RevisionableTrait;
    use ModelTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'playlists';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'thumb', 'short_description', 'description','lock'];
    protected $hidden = ['created_at', 'updated_at', 'creator_id', 'category_id'];
    // protected $dates = [];
    protected $appends = ['is_favorite', 'duration', 'creator', 'type'];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getTypeAttribute(){
        return 'playlist';
    }
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
    public function getDurationAttribute(){
        
        $duration = Audio::where('playlist_id', $this->id)->sum('duration');
        return (int)$duration;
    }
    
    public function getIsFavoriteAttribute(){
        $user_id = Request::get('user_id');
        $data = ['user_id' => $user_id, 'post_id' => $this->id, 'type' => 'playlist'];
        $check = UserFavorite::where($data)->count();
        return $check;
    }
    public function getThumbAttribute($value){
        if (Request::is('api*')) {
            return $this->get_domain_cdn().'/'.$value;
        }
        return $value;
    }
    public function setThumbAttribute($value)
    {
        $this->uploadFileToDisk($value, 'thumb', 'public', 'uploads/playlist/thumb');
        
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
    public function creator(){
        return $this->belongsTo('App\Models\Creator');
    }
    public function audios()
    {
    	return $this->hasMany('App\Models\Audio');
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
