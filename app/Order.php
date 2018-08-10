<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'lorry_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function inventories()
    {
        return $this->belongsToMany('App\Inventory');
    }

    public function driver()
    {
        return $this->belongsTo('App\User', 'lorry_id');
    }

    public function feedback()
    {
        return $this->hasOne('App\Feedback');
    }

    public function products()
    {
        return $this
            ->belongsToMany('App\Product')
            ->withPivot(
                'grade',
                'quantity'
            );
    }

    public function totalPrice()
    {
        return $this->products()
            ->get()
            ->sum(function ($product) {
                if ($product->pivot->grade === "A") {
                    return $product->priceValid($this->created_at)["buyer_price_a"] * $product->pivot->quantity;
                } else if ($product->pivot->grade === "B") {
                    return $product->priceValid($this->created_at)["buyer_price_b"] * $product->pivot->quantity;
                }
            });
    }

    public function totalQuantity()
    {
        return $this->products()
            ->get()
            ->sum('pivot.quantity');
    }

    public function getQuantityByProduct($product_id, $grade)
    {
        return $this->products()
            ->wherePivot('product_id', $product_id)
            ->wherePivot('grade', $grade)
            ->first()
            ->pivot
            ->quantity;
    }
}
