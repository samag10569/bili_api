<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsOrder extends Model
{
    protected $table = 'ads_order';

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
        return $this->belongsTo('App\Models\AdsOrderCategory', 'category_id','id');
    }


}
