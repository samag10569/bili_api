<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $table = 'logo';

    protected $fillable = [
        'id', 'title', 'image', 'link', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
