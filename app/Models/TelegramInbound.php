<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TelegramInbound extends Model
{
    protected $table = 'telegram_inbounds';

    protected $fillable = [
        'user_id','chat_id','update_id','message_id','user_name','first_name','text','response_text','response_date',
        'response_success','last_name','ticket_id'
    ];

    protected $casts = [
        'response_success' => 'boolean'
    ];
}