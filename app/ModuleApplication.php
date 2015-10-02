<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ModuleApplication extends Model
{
    use Translatable;


    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * Add your translated attributes here if you want
     * fill them with mass assignment.
     *
     * @var array
     */
    public $fillable = ['module_id'];

    public function module(){
        return $this->belongsTo('App\Module');
    }

    public function getModuleTypeAttribute(){
        return $this->module->name;
    }

}
