<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineUser extends Model
{
    protected $table = 'online_user';

    protected $fillable = [
        'session', 'time_s', 'date', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
}
