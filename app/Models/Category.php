<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use Request;
class Category extends Model
{
    use CrudTrait;
    use RevisionableTrait;
    use ModelTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'type', 'thumb', 'description', 'is_home', 'tab'];
    protected $hidden = ['created_at', 'updated_at'];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    
    public function getThumbAttribute($value){
        if (Request::is('api*')) {
            return $this->get_domain_cdn().'/'.$value;
        }
        return $value;
    }
    public function setThumbAttribute($value)
    {
        $this->uploadFileToDisk($value, 'thumb', 'public', 'uploads/category/thumb');
        
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    
    public function topics()
    {
    	return $this->hasMany('App\Models\Topic');
    }
    
     public function audios()
    {
    	return $this->hasMany('App\Models\Audio');
    }
    
    public function videos()
    {
    	return $this->hasMany('App\Models\Video');
    }
    
    public function playlists()
    {
    	return $this->hasMany('App\Models\Playlist');
    }
    
    public function albums()
    {
    	return $this->hasMany('App\Models\Album');
    }
    
    public function audiosTopic()
    {
        return $this->hasManyThrough('App\Models\Audio', 'App\Models\Topic');
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
