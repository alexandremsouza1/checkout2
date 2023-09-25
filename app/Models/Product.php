<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\Product as ProductContract;

class Product extends BaseModel implements ProductContract
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $hidden = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [];
    public $timestamps = true;

    public function getPrice()
    {
        return $this->price;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function hasImage()
    {
    }

    public function getImageUrl()
    {
    }

    public function findByCode($code)
    {
        return $this->where('code', $code)->first();
    }
}
