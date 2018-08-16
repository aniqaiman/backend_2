<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'price_id',
        'remark',
        'wastage',
        'promotion',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function price()
    {
        return $this->belongsTo('App\Price');
    }

    // public function promotions()
    // {
    //     return $this->belongsTo('App\Promotion');
    // }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    public function stocks()
    {
        return $this->belongsToMany('App\Stock');
    }

    public function totalPurchased($product_id)
    {
        return $this
            ->stocks
            ->map(function ($stock, $key) use ($product_id) {
                return $stock->getQuantityByProduct($product_id, 'A');
            })
            ->sum();
    }

    public function totalSold($product_id)
    {
        return $this
            ->orders
            ->map(function ($order, $key) use ($product_id) {
                return $order->getQuantityByProduct($product_id, 'A');
            })
            ->sum();
    }

    public function totalRemaining($product_id)
    {
        return $this->totalPurchased($product_id, 'A') - $this->totalSold($product_id, 'A');
    }

    public function totalRemainingActual($product_id)
    {
        return $this->totalRemaining($product_id, 'A') - $this->wastage - $this->promotion;
    }
}
