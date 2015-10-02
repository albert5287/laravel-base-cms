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
}
