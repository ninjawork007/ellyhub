<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'products';  
  
   public function ebay_category()
    {
      return $this->belongsTo(EbayCategory::class);
    }

    public function payment_policy()
    {
      return $this->belongsTo(EbayPaymentPolicy::class);
    }

    public function return_policy()
    {
      return $this->belongsTo(EbayReturnPolicy::class);
    }

    public function shipping_policy()
    {
      return $this->belongsTo(EbayShippingPolicy::class);
    }
}