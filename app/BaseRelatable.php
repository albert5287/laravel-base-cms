<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseRelatable extends Model
{
    /**
     * Get all of the media for an element.
     */
    public function media(){
        return $this->morphToMany('App\Media', 'mediable');
    }

    /**
     * sync up the medias in the db
     * @param array $medias
     */
    public function syncMedia(array $medias){
        $this->media()->sync($medias);
    }
}
