<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = [
        'id', 'title', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
