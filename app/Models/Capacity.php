<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacity extends Model
{
    protected $table = 'capacity';

    protected $fillable = [
        'id', 'capacity', 'date', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
