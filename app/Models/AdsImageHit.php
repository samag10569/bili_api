<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsImageHit extends Model
{
    protected $table = 'ads_image_hits';

    protected $guarded=['id'];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }

    public function ads()
    {
        return $this->belongsTo('App\Models\AdsImage', 'ads_id','id');
    }

   


}
