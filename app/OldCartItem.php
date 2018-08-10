<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldCartItem extends Model
{
    protected $table = 'cartitems';
    protected $primaryKey = 'cartitem_id';
    public $timestamps = false;
    protected $fillable = [
        'cartitem_id',
        'user_id',
        'product_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
