<?php

namespace App\Models;

use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cdn;
use URL;
trait ModelTrait
{
    protected function get_domain_cdn(){
        $cdn = Cdn::first();
        if($cdn->status == 1 && $cdn->domain != ''){
            return $cdn->domain;
        }
        return URL::to('/');
    }
    protected function _processUpload($value, $attributeName, $disk, $path) {
        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attributeName});

            // set null in the database column
            $this->attributes[$attributeName] = '';
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($path.'/'.$filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attributeName] = $path.'/'.$filename;
        } elseif(!starts_with($value, 'http')){
            $this->attributes[$attributeName] = $value;
        }
    }
}
