<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    protected $table = 'financial';

    protected $fillable = [

    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
