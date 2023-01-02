<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $table = 'help';

    protected $fillable = [
        'id', 'title', 'content', 'image', 'status_user', 'status_profile', 'status_grade',
        'status_service', 'status_project', 'content_short', 'listorder', 'status', 'section',
        'delete_temp'
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
