<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $fillable = [
        'id', 'user_id', 'factualy_id', 'title', 'file', 'content', 'status', 'created_at'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function factualy(){
        return $this->belongsTo('App\Models\FactualyList');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function reply()
    {
        return $this->hasMany('App\Models\MessageReply', 'message_id')->with('user','admin');
    }

}
