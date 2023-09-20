<?php
namespace App\Models;

// extends
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// includes
use App\Helpers\Token;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\State;
use App\Facades\AddressSearch;
use App\Helpers\Price;

class Cart extends BaseModel
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'carts';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;

    /***************************************************************************************
     ** MODS
     ***************************************************************************************/

    public static function boot()
    {
        parent::boot();
        static::creating(function ($cart) {
            $cart->token = Token::generate();
        });
        static::deleting(function ($cart) {
            $cart->cartItems()->delete();
        });
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function updateMe(array $data)
    {
        $this->customer_notes = Arr::has($data, 'customer_notes') ? $data['customer_notes'] : $this->customer_notes;
        $this->customer_email = Arr::has($data, 'customer_email') ? $data['customer_email'] : $this->customer_email;
        $this->shipping_first_name = Arr::has($data, 'shipping_first_name') ? $data['shipping_first_name'] : $this->shipping_first_name;
        $this->shipping_last_name = Arr::has($data, 'shipping_last_name') ? $data['shipping_last_name'] : $this->shipping_last_name;
        $this->shipping_address_line1 = Arr::has($data, 'shipping_address_line1') ? $data['shipping_address_line1'] : $this->shipping_address_line1;
        $this->shipping_address_line2 = Arr::has($data, 'shipping_address_line2') ? $data['shipping_address_line2'] : $this->shipping_address_line2;
        $this->shipping_address_city = Arr::has($data, 'shipping_address_city') ? $data['shipping_address_city'] : $this->shipping_address_city;
        $this->shipping_address_region = Arr::has($data, 'shipping_address_region') ? $data['shipping_address_region'] : $this->shipping_address_region;
        $this->shipping_address_phone = Arr::has($data, 'shipping_address_phone') ? $data['shipping_address_phone'] : $this->shipping_address_phone;
        $this->shipping_address_zipcode = Arr::has($data, 'shipping_address_zipcode') ? $data['shipping_address_zipcode'] : $this->shipping_address_zipcode;

        $this->billing_same = Arr::has($data, 'billing_same') ? $data['billing_same'] : $this->billing_same;

        if (Arr::has($data, 'billing_same') && !$data['billing_same']) {
            $this->billing_first_name = null;
            $this->billing_last_name = null;
            $this->billing_address_line1 = null;
            $this->billing_address_line2 = null;
            $this->billing_address_city = null;
            $this->billing_address_region = null;
            $this->billing_address_zipcode = null;
            $this->billing_address_phone = null;
        } else if ($this->billing_same) {
            $this->billing_first_name = $this->shipping_first_name;
            $this->billing_last_name = $this->shipping_last_name;
            $this->billing_address_line1 = $this->shipping_address_line1;
            $this->billing_address_line2 = $this->shipping_address_line2;
            $this->billing_address_city = $this->shipping_address_city;
            $this->billing_address_region = $this->shipping_address_region;
            $this->billing_address_zipcode = $this->shipping_address_zipcode;
            $this->billing_address_phone = $this->shipping_address_phone;
        } else {
            $this->billing_first_name = Arr::has($data, 'billing_first_name') ? $data['billing_first_name'] : $this->billing_first_name;
            $this->billing_last_name = Arr::has($data, 'billing_last_name') ? $data['billing_last_name'] : $this->billing_last_name;
            $this->billing_address_line1 = Arr::has($data, 'billing_address_line1') ? $data['billing_address_line1'] : $this->billing_address_line1;
            $this->billing_address_line2 = Arr::has($data, 'billing_address_line2') ? $data['billing_address_line2'] : $this->billing_address_line2;
            $this->billing_address_city = Arr::has($data, 'billing_address_city') ? $data['billing_address_city'] : $this->billing_address_city;
            $this->billing_address_region = Arr::has($data, 'billing_address_region') ? $data['billing_address_region'] : $this->billing_address_region;
            $this->billing_address_zipcode = Arr::has($data, 'billing_address_zipcode') ? $data['billing_address_zipcode'] : $this->billing_address_zipcode;
            $this->billing_address_phone = Arr::has($data, 'billing_address_phone') ? $data['billing_address_phone'] : $this->billing_address_phone;
        }

        $this->save();
    }

    public function addCoupon(array $data)
    {
        if (isset($data['coupon_code'])) {
            $coupon = \App\Facades\Coupon::getClassName()::byCode($data['coupon_code'])->first();
            $this->{\App\Facades\Coupon::getForeignKey()} = $coupon->id;
            $this->discount = $coupon->calculateDiscount($this);
            $this->setTax();
            $this->setTotal();
        }
    }

    public function removeCoupon()
    {
        $coupon = $this->coupon;

        if (!$coupon) {
            return;
        }

        $this->{\App\Facades\Coupon::getForeignKey()} = null;
        $this->discount = 0;
        $this->setTax();
        $this->setTotal();
    }

    public function updateZipCode(array $data)
    {
        if (Arr::has($data, 'zipcode')) {
            $address = AddressSearch::getByPostalCode($data['zipcode'])->first();

            if (!is_null($address)) {
                /** @var State $states */
                $states = app(State::class);
                $this->shipping_address_city = $address->getCityName();
                $this->shipping_address_region = Arr::get($states->getByCode($address->getStateCode()), 'value');
                $this->save();
            }
        }
    }

    public function updateShipping(array $data)
    {
    }

    public function updateEmail(array $data)
    {
    }

    public function addOptions(array $options)
    {
        $this->options = $options;
        $this->save();
    }

    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

    public function customer()
    {
        return $this->belongsTo(\App\Facades\Customer::getClassName(), \App\Facades\Customer::getForeignKey());
    }

    public function cartItems()
    {
        return $this->hasMany(\App\Facades\CartItem::getClassName(), \App\Facades\Cart::getForeignKey());
    }

    public function coupon()
    {
        return $this->belongsTo(\App\Facades\Coupon::getClassName(), \App\Facades\Coupon::getForeignKey());
    }

    public function order()
    {
        return $this->hasOne(\App\Facades\Order::getClassName(), \App\Facades\Cart::getForeignKey());
    }


    /***************************************************************************************
     ** SCOPES
     ***************************************************************************************/

    public function scopeByToken($query, $token)
    {
        return $query->where('token', $token);
    }

    /***************************************************************************************
     ** HELPERS
     ***************************************************************************************/
    public function setItemSubtotal()
    {
        $this->items_subtotal = $this->cartItems->sum(function (CartItem $cartItem) {
            return $cartItem->price;
        });

        $this->save();
    }

    public function setTotal()
    {
        $this->total = $this->items_subtotal + $this->shipping - $this->discount + $this->tax;
        $this->save();
    }

    public function setDiscount()
    {
        if (!is_null($this->{\App\Facades\Coupon::getForeignKey()})) {
            $this->discount = $this->coupon->calculateDiscount($this);
            $this->save();
        }
    }

    public function setTax()
    {
        $this->tax = Price::getTax($this->items_subtotal - $this->discount, $this->tax_rate);
        $this->save();
    }

    public function hasDiscount()
    {
        return $this->discount > 0;
    }
}
