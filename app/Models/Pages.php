<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'id', 'title', 'content', 'image', 'link', 'listorder', 'status',
    ];

    public function getDateFormat()
    {
        return 'U';
    }

}
