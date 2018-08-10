<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'short_description',
        'image',
        'category_id',
        'quantity_a',
        'quantity_b',
        'demand_a',
        'demand_b',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function carts()
    {
        return $this
            ->belongsToMany('App\User', 'carts')
            ->withPivot(
                'grade',
                'quantity'
            );
    }

    public function supplies()
    {
        return $this->belongsToMany('App\User', 'supplies')
            ->withPivot(
                'harvesting_period_start',
                'harvesting_period_end',
                'harvest_frequency',
                'total_plants',
                'total_farm_area'
            );
    }

    public function orders()
    {
        return $this
            ->belongsToMany('App\Order')
            ->withPivot(
                'grade',
                'quantity'
            );
    }

    public function stocks()
    {
        return $this
            ->belongsToMany('App\Stock')
            ->withPivot(
                'grade',
                'quantity'
            );
    }

    public function prices()
    {
        return $this->hasMany('App\Price');
    }

    public function pricesValid($order_date)
    {
        return $this->prices()
            ->where('date_price', '<=', $order_date)
            ->orderBy('date_price', 'desc');
    }

    public function priceValid($order_date)
    {
        return $this->pricesValid($order_date)
            ->first();
    }

    public function priceExact($order_date)
    {
        return $this->prices()
            ->whereDate('date_price', '=', $order_date)
            ->first();
    }

    public function getPriceLatestAttribute()
    {
        return $this->pricesValid(Carbon::now())
            ->first();
    }

    public function getPricePreviousAttribute()
    {
        return $this->pricesValid(Carbon::now())
            ->skip(1)
            ->first();
    }

    public function getPriceTodayAttribute()
    {
        return $this->priceExact(Carbon::today());
    }

    public function getPriceYesterdayAttribute()
    {
        return $this->priceExact(Carbon::yesterday());
    }

    public function getPriceDifferenceAttribute()
    {
        return (object) [
            'seller_price_a' => is_null($this->price_previous) || $this->price_previous['seller_price_a'] == 0 ? 0 : round(($this->price_latest['seller_price_a'] - $this->price_previous['seller_price_a']) / $this->price_previous['seller_price_a'], 2),
            'seller_price_b' => is_null($this->price_previous) || $this->price_previous['seller_price_b'] == 0 ? 0 : round(($this->price_latest['seller_price_b'] - $this->price_previous['seller_price_b']) / $this->price_previous['seller_price_b'], 2),
            'buyer_price_a' => is_null($this->price_previous) || $this->price_previous['buyer_price_a'] == 0 ? 0 : round(($this->price_latest['buyer_price_a'] - $this->price_previous['buyer_price_a']) / $this->price_previous['buyer_price_a'], 2),
            'buyer_price_b' => is_null($this->price_previous) || $this->price_previous['buyer_price_b'] == 0 ? 0 : round(($this->price_latest['buyer_price_b'] - $this->price_previous['buyer_price_b']) / $this->price_previous['buyer_price_b'], 2),
        ];
    }

    public function getPriceTodayYesterdayDifferenceAttribute()
    {
        $today = $this->price_today;
        $yesterday = $this->price_yesterday;

        return (object) [
            'seller_price_a' => is_null($today) || is_null($yesterday) || $yesterday['seller_price_a'] == 0 ? 0 : round(($today['seller_price_a'] - $yesterday['seller_price_a']) / $yesterday['seller_price_a'], 2),
            'seller_price_b' => is_null($today) || is_null($yesterday) || $yesterday['seller_price_b'] == 0 ? 0 : round(($today['seller_price_b'] - $yesterday['seller_price_b']) / $yesterday['seller_price_b'], 2),
            'buyer_price_a' => is_null($today) || is_null($yesterday) || $yesterday['buyer_price_a'] == 0 ? 0 : round(($today['buyer_price_a'] - $yesterday['buyer_price_a']) / $yesterday['buyer_price_a'], 2),
            'buyer_price_b' => is_null($today) || is_null($yesterday) || $yesterday['buyer_price_b'] == 0 ? 0 : round(($today['buyer_price_b'] - $yesterday['buyer_price_b']) / $yesterday['buyer_price_b'], 2),
        ];
    }

    public function promotions()
    {
        return $this->hasMany('App\Promotion');
    }

    public function wastages()
    {
        return $this->hasMany('App\Wastage');
    }

    public function scopeGetFull($query)
    {
        return $query
            ->has('prices')
            ->with('category')
            ->orderBy('products.name', 'asc')
            ->getWithPrice();
    }

    public function scopeGetMinimal($query)
    {
        return $query
        ->has('prices')
        ->with('category')
        ->orderBy('products.name', 'asc')
        ->get();
    }
    
    public function scopeGetFullPromotion($query)
    {
        return $query
            ->with("category")
            ->has('prices')
            ->whereHas('promotions', function ($promotion) {
                $promotion->whereRaw('total_sold < quantity');
            })
            ->getWithPrice();
    }
    
    public function scopeGetFullByDate($query, $date)
    {
        return $query
            ->has('prices')
            ->with('category')
            ->orderBy('products.name', 'asc')
            ->getWithPriceByDate($date);
    }

    public function scopeGetFullByCategory($query, $category)
    {
        return $query
            ->has('prices')
            ->with('category')
            ->orderBy('products.name', 'asc')
            ->where('category_id', $category)
            ->getWithPrice();
    }

    public function scopeGetMinimalByCategory($query, $category)
    {
        return $query
            ->has('prices')
            ->with('category')
            ->orderBy('products.name', 'asc')
            ->where('category_id', $category)
            ->get();
    }

    public function scopeGetWithPrice($query)
    {
        return $query
            ->get()
            ->each(function ($product) {
                $product['price'] = $product->price_latest;
                $product['price_difference'] = $product->price_difference;
            });
    }

    public function scopeGetWithPriceByDate($query, $date)
    {
        return $query
            ->get()
            ->each(function ($product) use ($date) {
                $product['price'] = $product->priceValid($date);
                $product['price_difference'] = $product->price_difference;
            });
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->prices()->delete();
            $product->promotions()->delete();
            $product->wastages()->delete();

            $product->carts()->detach();
            $product->orders()->detach();
            $product->stocks()->detach();
            $product->supplies()->detach();
        });
    }
}
