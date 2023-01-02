<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllotmentMessage extends Model
{
    protected $table = 'allotment_message';

    protected $fillable = [
        'user_id', 'allotment_id', 'admin_id', 'content', 'status', 'created_at'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function userAdmin()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }
}
