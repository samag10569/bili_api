<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scientific extends Model
{
    protected $table = 'scientific';

    protected $fillable = [
        'id', 'title', 'content', 'image', 'content_short', 'listorder',
        'status', 'user_id', 'category_id', 'isadmin', 'keywords', 'description'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\ScientificCategory', 'category_id');
    }

    public function scopeDeleteTemp($query)
    {
        $records = $query->whereNull('delete_temp');
        return $records;
    }
    public function comments()
    {
        return $this->hasMany('App\Models\ScientificComments', 'scientific_id')->where('parent_id',0);
    }


}
