<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'company_id',
    ];

    /**
     * relation between module and application
     * @return mixed
     */
    public function availableModules(){
        return $this->belongsToMany('App\Module')->withTimestamps()->withTranslation();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany('Bican\Roles\Models\Role')->withTimestamps();
    }

    /**
     * function to check if 2 applications are the same
     * @param Application $app
     * @return bool
     */
    public function isEqual(Application $app){
        return $this->id === $app->id;
    }
}
