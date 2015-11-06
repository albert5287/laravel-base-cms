<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use Translatable;

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = ['title'];

    /**
     * Add your translated attributes here if you want
     * fill them with mass assignment.
     *
     * @var array
     */
    public $fillable = ['class' ,'name', 'enabled', 'show_sidebar', 'is_content_module', 'only_super_admin', 'default_app'];
    
    /**
     * queryScope to get all active content modules
     * @param $query
     */
    public function scopeActiveContentModules($query){
        $query->withTranslation()->where('is_content_module', '=', true);
    }

    /**
     * queryScope to get all default modules for an app
     * @param $query
     */
    public function scopeDefaultAppModules($query){
        $query->withTranslation()->where('default_app', '=', true);
    }
}
