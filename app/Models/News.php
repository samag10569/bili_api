<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'id', 'title', 'content', 'image', 'content_short', 'listorder', 'status', 'keywords', 'description', 'hits'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }


    public function scopeDeleteTemp($query)
    {
        $records = $query->whereNull('delete_temp');
        return $records;
    }


}
