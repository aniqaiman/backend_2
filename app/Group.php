<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
