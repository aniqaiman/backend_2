<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OldOrderItem extends Pivot
{
    protected $table = 'orderitems';
    protected $primaryKey = 'orderitem_id';
    public $timestamps = false;
    protected $fillable = [
        'orderitem_id',
        'order_id',
        'product_id',
        'quantity'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
