<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'order_id',
        'stock_id',
        'topic',
        'description',
        'response',
        'has_read',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }
}
