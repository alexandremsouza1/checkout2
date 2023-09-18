<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;

// extends
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'order_items';
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];
    public $timestamps = true;


    /***************************************************************************************
     ** RELATIONS
     ***************************************************************************************/

    public function product()
    {
        return $this->belongsTo(\App\Facades\Product::getClassName(), \App\Facades\Product::getForeignKey());
    }

    public function cartItem()
    {
        return $this->belongsTo(\App\Facades\CartItem::getClassName(), \App\Facades\CartItem::getForeignKey());
    }

    /***************************************************************************************
     ** CRUD
     ***************************************************************************************/

    public static function makeOne(array $data)
    {
        $orderItem = new self;

        $productForeignKey = \App\Facades\Product::getForeignKey();
        $cartItemForeignKey = \App\Facades\CartItem::getForeignKey();

        $orderItem->order_id = Arr::get($data, 'order_id');
        $orderItem->{$productForeignKey} = Arr::get($data, $productForeignKey);
        $orderItem->{$cartItemForeignKey} = Arr::get($data, $cartItemForeignKey);
        $orderItem->price = Arr::get($data, 'price');
        $orderItem->quantity = Arr::get($data, 'quantity');
        $orderItem->name = Arr::get($data, 'name');
        $orderItem->customer_note = Arr::get($data, 'customer_note');
        $orderItem->save();

        return $orderItem;
    }

    public static function makeOneFromCartItem(CartItem $cartItem, $orderId)
    {
        $product = $cartItem->product;

        $productForeignKey = \App\Facades\Product::getForeignKey();
        $orderForeignKey = \App\Facades\Order::getForeignKey();
        $cartItemForeignKey = \App\Facades\CartItem::getForeignKey();

        $orderItem = static::makeOne([
            $orderForeignKey => $orderId,
            $productForeignKey => $product->id,
            $cartItemForeignKey => $cartItem->id,
            'price' => $cartItem->price,
            'quantity' => $cartItem->quantity,
            'name' => $product->getName(),
            'customer_note' => $cartItem->customer_note
        ]);

        return $orderItem;
    }
}
