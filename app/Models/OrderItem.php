<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';

    protected $fillable = [
        'order_id', 'allotment_id', 'price', 'quantity', 'total_price', 'gold_price',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function allotment()
    {
        return $this->belongsTo('App\Models\Allotment', 'allotment_id', 'id')->withTrashed();
    }

    public function orders()
    {
        return $this->belongsTo('App\Models\Orders', 'order_id', 'id');
    }

}
