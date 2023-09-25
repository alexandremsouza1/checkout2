<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Contracts\Customer as CustomerContract;

class Payment extends BaseModel
{

  protected $guarded = ['id'];
  protected $hidden = [];
  protected $dates = ['created_at', 'updated_at'];
  protected $casts = [
    'default' => 'boolean',
    'blocked' => 'boolean',
    'total' => 'float',
    'fee' => 'float',
    'installments' => 'integer',
    'days' => 'integer',
    'number' => 'integer',
  ];
  public $timestamps = true;

  protected $fillable = [
    'hash',
    'cart_id',
    'billing_app',
    'blocked',
    'name',
    'client_id',
    'description',
    'payment_method_description',
    'payment_condition',
    'fee',
    'payment_method',
    'message',
    'block_reason',
    'number',
    'default',
    'days',
    'installments',
    'type',
    'partial_amount',
    'total_amount',
  ];

  public function cart()
  {
      return $this->belongsTo(Cart::class, 'cart_id');
  }
}
