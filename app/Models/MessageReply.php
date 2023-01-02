<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    protected $table = 'message_reply';

    protected $fillable = [
        'id', 'user_id', 'message_id', 'admin_id', 'content', 'created_at'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function admin(){
        return $this->belongsTo('App\User','admin_id');
    }

}
