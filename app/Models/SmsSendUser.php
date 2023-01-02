<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsSendUser extends Model
{
    protected $table = 'sms_send_user';

    protected $fillable = [
        'sms_send_id', 'user_id', 'status', 'type'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function contactsList()
    {
        return $this->belongsTo('App\Models\ContactsList', 'user_id');
    }

    public function smsExcel()
    {
        return $this->belongsTo('App\Models\SmsExcel', 'user_id');
    }

}
