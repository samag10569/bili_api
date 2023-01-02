<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersMembershipType extends Model
{
    protected $table = 'orders_membership_type';

    protected $fillable = [
        'user_id', 'status', 'total_price', 'payments', 'membership_type_id', 'ref_id', 'gateway_transaction_id', 'tracking_code',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function membershipType()
    {
        return $this->belongsTo('App\Models\MembershipType', 'membership_type_id', 'id');
    }

}
