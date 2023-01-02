<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageCore extends Model
{
    protected $table = 'message_core';

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
        return $this->belongsTo('App\User','user_id');
    }

    public function reply()
    {
        return $this->hasMany('App\Models\MessageCoreReply', 'message_core_id')->with('user','admin');
    }
}
