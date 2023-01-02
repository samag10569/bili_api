<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsOrderCategory extends Model
{
    protected $table = 'ads_order_category';

    protected $fillable = [
        'listorder', 'title', 'status','parent_id'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function allotment()
    {
        return $this->hasMany('App\Models\Allotment', 'category_id');
    }
    public function parent()
    {
        return $this->hasOne('App\Models\AllotmentCategory', 'id', 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany('App\Models\AllotmentCategory', 'parent_id', 'id');
    }

}
