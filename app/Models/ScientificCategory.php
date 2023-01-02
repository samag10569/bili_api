<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScientificCategory extends Model
{
    protected $table = 'scientific_category';

    protected $fillable = [
        'listorder', 'title', 'status','parent_id','delete_temp'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function parent()
    {
        return $this->hasOne('App\Models\ScientificCategory', 'id', 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany('App\Models\ScientificCategory', 'parent_id', 'id');
    }

    public function scientific()
    {
        return $this->hasMany('App\Models\Scientific', 'category_id');
    }

    public function scopeDeleteTemp($query)
    {
        $records = $query->whereNull('delete_temp');
        return $records;
    }

}
