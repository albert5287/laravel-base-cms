<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'company_id',
    ];

    public function availableModules(){
        return $this->belongsToMany('App\Module')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function isEqual(Application $app){
        return $this->id === $app->id;
    }
}
