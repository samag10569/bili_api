<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $table = 'degree';

    protected $fillable = [
        'id', 'title', 'listorder', 'status', 'min', 'max',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
