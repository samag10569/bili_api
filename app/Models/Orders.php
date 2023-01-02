<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'status', 'total_price', 'payments', 'quantity', 'ref_id', 'gateway_transaction_id', 'tracking_code',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction', 'transaction_id', 'id');
    }

    public function item()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }

}
