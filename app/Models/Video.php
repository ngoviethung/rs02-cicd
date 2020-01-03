<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use App\Models\UserFavorite;
use Request;

class Video extends Model
{
    use CrudTrait;
    use RevisionableTrait;
    use ModelTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'videos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['name','duration', 'thumb', 'mp4', 'short_description', 'description','lock'];
    protected $hidden = ['created_at', 'updated_at', 'category_id', 'topic_id'];
    // protected $dates = [];
    protected $appends = ['is_favorite', 'type'];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getTypeAttribute(){
        return 'video';
    }
    
    public function getImageSizeAttribute(){
        $value = $this->thumb;
        list($width, $height) = getimagesize($value);
        
        return [
            'width' => $width,
            'height' => $height
        ];
        
    }
    
    public function getIsFavoriteAttribute(){
        $user_id = Request::get('user_id');
        $data = ['user_id' => $user_id, 'post_id' => $this->id, 'type' => 'video'];
        $check = UserFavorite::where($data)->count();
        return $check;
    }
    
    public function getThumbAttribute($value){
        if (Request::is('api*')) {
            return $this->get_domain_cdn().'/'.$value;
        }
        return $value;
    }
    
     public function getMp4Attribute($value){
        if (Request::is('api*')) {
            return $this->get_domain_cdn().'/'.$value;
        }
        return $value;
    }
    public function setThumbAttribute($value)
    {
        $this->uploadFileToDisk($value, 'thumb', 'public', 'uploads/thumb');
        
    }

     public function setMp4Attribute($value)
    {
        $this->uploadFileToDisk($value, 'mp4', 'public', 'uploads/mp4');
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
