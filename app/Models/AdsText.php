<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdsText extends Model
{
    protected $table = 'ads_texts';

    
     protected $fillable = [
        'id', 'title', 'content', 'gender', 'state', 'city',
        'lat', 'lng', 'shakhe', 'reshte','gerayesh','daste','status','user_id',
        'start_at', 'expire_at', 'price'
    ];   

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id','id');
    }
    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state','id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city','id');
    }
    public function shakhe()
    {
        return $this->belongsTo('App\Models\Shakheh', 'shakhe','id');
    }
    public function reshte()
    {
        return $this->belongsTo('App\Models\Reshteh', 'reshte','id');
    }
    public function gerayesh()
    {
        return $this->belongsTo('App\Models\Gerayesh', 'gerayesh','id');
    }
    public function daste()
    {
        return $this->belongsTo('App\Models\Dasteh', 'daste','id');
    }

}
