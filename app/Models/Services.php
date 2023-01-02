<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'id', 'title', 'content', 'image', 'content_short', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
