<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop_id','id');
    }


}
