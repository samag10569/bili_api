<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCustomerMsg extends Model
{
    protected $table = 'shop_customer_msgs';
    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop_id','id');
    }


}
