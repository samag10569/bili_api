<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    protected $table = 'shop_category';

    protected $fillable = [
        'listorder', 'title', 'status','parent_id'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\ShopCategory', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\ShopCategory', 'parent_id', 'id');
    }


}
