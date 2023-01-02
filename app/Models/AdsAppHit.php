<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsAppHit extends Model
{
    protected $table = 'ads_apps_hits';

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
        return $this->belongsTo('App\Models\AdsApp', 'ads_id','id');
    }




}
