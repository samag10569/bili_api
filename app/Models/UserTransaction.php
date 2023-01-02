<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    protected $table = 'user_transactions';

    public function getCreatedAtAttribute($value)
    {
        $cDate = Carbon::parse($value);
        return gregorian_to_jalali($cDate->year, $cDate->month, $cDate->day, '/');
    }
    protected function getDateFormat()
    {
        return 'U';
    }

    public function orders()
    {
        return $this->hasOne('App\Models\Orders', 'id', 'order_id');
    }

    public function ordersMembershipType()
    {
        return $this->hasOne('App\Models\OrdersMembershipType', 'id', 'order_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
