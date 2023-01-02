<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllotmentOption extends Model
{
    protected $table = 'allotment_option';

    protected $fillable = [
        'user_id', 'allotment_id', 'admin_id', 'content', 'status', 'created_at'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
