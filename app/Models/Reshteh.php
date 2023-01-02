<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reshteh extends Model
{
    protected $table = 'reshteh';

    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function shakheh()
    {
        return $this->belongsTo('App\Models\Shakheh', 'shakheh_id','id');
    }



}
