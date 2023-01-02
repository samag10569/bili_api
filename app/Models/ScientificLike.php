<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScientificLike extends Model
{
    protected $table = 'scientific_like';

    protected $fillable = [
        'id', 'ip', 'rate', 'scientific_id'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
