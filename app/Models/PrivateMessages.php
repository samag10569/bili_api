<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessages extends Model
{
    protected $table = 'private_messages';

    protected $fillable = [
        'user_id_from','user_id_to','parent_id','subject','message', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function sender()
    {
        return $this->belongsTo('App\User','user_id_from');
    }
    public function receiver()
    {
        return $this->belongsTo('App\User','user_id_to');
    }

}
