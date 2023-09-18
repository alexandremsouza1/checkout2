<?php

namespace App\Models;



class Product extends BaseModel
{

  protected $fillable = [
    "suggestedQuantity",
    "stock",
    "action",
    "charge",
    "code",
    "weight",
    "unitFactor",
    "productName",
    "kit",
    "material",
    "polarized",
    "unitPrice",
    "priceTable",
    "orderType",
    "segment",
    "brand",
    "category",
    "packagingType",
    "groupKonnect",
    "deliveryType",
    "flavor",
  ];


  protected $rules = [];


  public function rules()
  {
    return $this->rules;
  }

  public function getDependencies()
  {
    return [];
  }
}
