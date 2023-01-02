<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $table = 'tracker';

    protected $fillable = [
        'count', 'date'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
}
