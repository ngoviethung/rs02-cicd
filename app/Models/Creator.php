<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use Request;

class Creator extends Model
{
    use CrudTrait;
    use RevisionableTrait;
    use ModelTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'creators';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['avatar', 'name', 'introduce'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getAvatarAttribute($value){
        if (Request::is('api*')) {
            return $this->get_domain_cdn().'/'.$value;
        }
        return $value;
    }
    public function setAvatarAttribute($value)
    {
        $this->uploadFileToDisk($value, 'avatar', 'public', 'uploads/avatar');
        
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    
    
    public function audios(){
        return $this->hasMany('App\Models\Audio');
    }
    
     public function playlists(){
        return $this->hasMany('App\Models\Playlist');
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
