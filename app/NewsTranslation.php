<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'new_translations';

    public $timestamps = false;
}
