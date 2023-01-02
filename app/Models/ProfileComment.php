<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileComment extends Model
{
    protected $table = 'profile_comments';

    protected $fillable = [
        'mainuser_id','user_id','parent_id','comment'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function sender()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','mainuser_id');
    }

}
