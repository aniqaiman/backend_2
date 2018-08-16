<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'product_id',
        'stock_id',
        'wastage',
        'price',
        'buy_at_price',
        'total_sold',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    // public function inventories()
    // {
    //     return $this->belongsTo('App\Inventory');
    // }

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }

    public function totalRemaining() {
        return $this->quantity - $this->total_sold;
    }

}
