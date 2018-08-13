<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LorryType extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'type',
    ];

    public function lorries()
    {
        return $this->hasMany('App\User');
    }
}
