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
        return $this->belongsToMany('App\Module')->withTimestamps()->withTranslation();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        //return $this->belongsToMany('Bican\Roles\Models\Role');
    }

    public function isEqual(Application $app){
        return $this->id === $app->id;
    }
}
