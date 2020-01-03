<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use Request;
use App\Models\UserFavorite;
use App\Models\Audio;

class Album extends Model
{
    use CrudTrait;
    use RevisionableTrait;
    use ModelTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'albums';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['name','thumb', 'description', 'short_description','lock'];
    protected $hidden = ['created_at', 'updated_at'];
    // protected $dates = [];
    protected $appends = ['is_favorite', 'duration', 'type'];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getTypeAttribute(){
        return 'album';
    }
     public function getDurationAttribute(){
        $duration = Audio::where('album_id', $this->id)->sum('duration');
        return (int)$duration;
    }
    public function getIsFavoriteAttribute(){
        $user_id = Request::get('user_id');
        $data = ['user_id' => $user_id, 'post_id' => $this->id, 'type' => 'album'];
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
