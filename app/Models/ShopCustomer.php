<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCustomer extends Model
{
    protected $table = 'shop_customers';
    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }



}
