<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allotment extends Model
{
    use SoftDeletes;
    protected $table = 'allotment';
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

    protected $fillable = [
        'id', 'title', 'content', 'value', 'perm', 'category_id', 'listorder',
        'status', 'option', 'price', 'gold_price', 'profit', 'capacity', 'description',
        'image', 'score'
    ];

    public function getDateFormat()
    {
        return 'U';
    }

    public function category()
    {
        return $this->belongsTo('App\Models\AllotmentCategory', 'category_id');
    }

    public function allotmentOption()
    {
        return $this->hasMany('App\Models\AllotmentOption', 'allotment_id');
    }

}
