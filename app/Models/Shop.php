<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';

    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\AllotmentCategory', 'category_id');
    }
    public function customer()
    {
        return $this->hasMany('App\Models\ShopCustomer', 'shop_id');
    }
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'shop_id');
    }

}
