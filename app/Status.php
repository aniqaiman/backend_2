<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';
    public $timestamp = 'true';
    protected $fillable = [
    	'status'
    	];

    	public function user()
    	{
    		return $this->belongsTo('App\User');
    	}
}
