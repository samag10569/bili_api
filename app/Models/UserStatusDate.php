<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatusDate extends Model
{
    protected $table = 'user_status_date';

    protected $fillable = [
        'user_id', 'status_id'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
