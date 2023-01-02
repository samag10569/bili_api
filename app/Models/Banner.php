<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banner';

    protected $fillable = [
        'id', 'title', 'content', 'image','section', 'link', 'listorder', 'status',
    ];

    public function getDateFormat()
    {
        return 'U';
    }

}
