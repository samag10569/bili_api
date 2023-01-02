<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCustomerCat extends Model
{
    protected $table = 'shop_customer_cats';
    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }



}
