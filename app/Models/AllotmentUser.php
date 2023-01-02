<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllotmentUser extends Model
{
    protected $table = 'allotment_user';

    protected $fillable = [
        'user_id', 'admin_id', 'allotment_id', 'amount', 'inspector_amount', 'status', 'date_confirm'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }


    public function allotment()
    {
        return $this->belongsTo('App\Models\Allotment', 'allotment_id')->withTrashed();
    }

    public function scopeAllotmentWithStatus($query, $status_id, $allotment_id)
    {
        $records = $query->where('allotment_user.status', $status_id)
            ->whereAllotmentId($allotment_id)
            ->with('user.userStatus');
        return $records;
    }
}
