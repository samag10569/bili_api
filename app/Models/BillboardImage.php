<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillboardImage extends Model
{
    protected $table = 'billboard_images';


    protected function getDateFormat()
    {
        return 'U';
    }



    public function orders()
    {
        return $this->belongsTo('App\Models\Billboard', 'b_id', 'id');
    }

}
