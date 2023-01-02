<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';

    protected $fillable = [
        'id', 'title', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
