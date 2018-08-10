<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LorryCapacity extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'capacity',
    ];

    public function lorries()
    {
        return $this->hasMany('App\User');
    }
}
