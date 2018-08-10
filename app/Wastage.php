<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Wastage extends Model
{
    protected $fillable = [
        'date',
        'product_id',
        'storage_wastage',
        'promo_wastage',
        'buy_at_price',
    
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}
