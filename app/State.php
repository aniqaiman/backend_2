<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'name',
    ];

    public function lorries()
    {
        return $this->hasMany('App\User');
    }
}
