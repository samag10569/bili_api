<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dasteh extends Model
{
    protected $table = 'dasteh';

    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function gerayesh()
    {
        return $this->belongsTo('App\Models\Gerayesh', 'gerayesh_id','id');
    }



}
