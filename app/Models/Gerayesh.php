<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gerayesh extends Model
{
    protected $table = 'gerayesh';

    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function reshteh()
    {
        return $this->belongsTo('App\Models\Reshteh', 'reshteh_id','id');
    }



}
