<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credibility extends Model
{
    protected $table = 'credibility';

    protected $fillable = [
        'id', 'title', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
