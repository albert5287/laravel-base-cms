<?php
use App\Language;
use App\Module;

/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 29.09.2015
 * Time: 16:35
 */

//TODO
//filter by active languages
//maybe change to the model
function getActiveLanguages(){
    return Language::all();
}
//TODO
//filter by active Modules
//maybe change to the model
function getActiveModules(){
    return Module::all();
}

function insertUpdateMultiLanguage($element, $newValues){
    foreach($newValues as $key => $value){
        if(strpos($key, '_') === false){
            if(is_array($value)){
                foreach($value as $lang => $val){
                    $element->translateOrNew($lang)->$key = $val;
                }
            }
            else{
                $element->$key = $value;
            }
        }
    }
    $element->save();
}