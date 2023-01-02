<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billboard extends Model
{
    protected $table = 'billboards';

    protected $fillable = [
        'id', 'name', 'location', 'type', 'content', 'price_1h',
        'price_1d', 'price_1m', 'price_3m', 'price_6m','price_1yr','image','status','type','type2','id_camera','ip_tv','state_id','city'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function image()
    {
        return $this->hasMany('App\Models\BillboardImage', 'b_id');
    }

}
