<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use URL;
use Request;

class Cdn extends Model
{
    use CrudTrait;
    use ModelTrait;
    use RevisionableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'cdn_settings';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['domain','status'];
    
  
    
}
