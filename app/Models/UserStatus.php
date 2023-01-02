<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $table = 'user_status';

    protected $fillable = [
        'title', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
