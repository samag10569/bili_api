<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';

    protected $fillable = [
        'id', 'title', 'listorder', 'status', 'parent_id',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
