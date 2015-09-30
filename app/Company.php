<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'street',
        'city',
        'phone',
        'email',
    ];
}
