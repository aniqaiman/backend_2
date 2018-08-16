<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $hidden = ['password', 'remember_token'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone_number',
        'mobile_number',
        'display_picture',
        'remember_token',
        'group_id',
        'company_name',
        'company_registration_mykad_number',
        'bussiness_hour',
        'bank_name',
        'bank_account_holder_name',
        'bank_account_number',
        'latitude',
        'longitude',
        'driver_license_number',
        'driver_license_picture',
        'lorry_roadtax_expiry',
        'lorry_type_id',
        'lorry_capacity_id',
        'lorry_plate_number',
        'state_id',
        'status_email',
        'status_account',
        'location_covered',
        'profile_verified',
    ];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function lorryCapacity()
    {
        return $this->belongsTo('App\LorryCapacity');
    }

    public function lorryType()
    {
        return $this->belongsTo('App\LorryType');
    }

    public function lorryLocationCover()
    {
        return $this->belongsTo('App\State');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function carts()
    {
        return $this->belongsToMany('App\Product', 'carts')
            ->withPivot(
                'grade',
                'quantity'
            );
    }

    public function totalCartItems()
    {
        return $this->carts()->count();
    }

    public function totalCartPrice()
    {
        return $this->carts()
            ->get()
            ->sum(function ($cart) {
                if ($cart->pivot->grade === "A") {
                    return $cart->price_latest["buyer_price_a"] * $cart->pivot->quantity;
                } else if ($cart->pivot->grade === "B") {
                    return $cart->price_latest["buyer_price_b"] * $cart->pivot->quantity;
                }
            });
    }

    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }

    public function supplies()
    {
        return $this->belongsToMany('App\Product', 'supplies')
        ->withPivot(
            'harvesting_period_start',
            'harvesting_period_end',
            'harvest_frequency',
            'total_plants',
            'total_farm_area'
        );
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
