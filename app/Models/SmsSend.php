<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsSend extends Model
{
    protected $table = 'email_send';

    protected $fillable = [
        'count', 'sender', 'subject', 'content', 'type'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function smsUser()
    {
        return $this->hasMany('App\Models\SmsSendUser');
    }

    public function smsUserFaild()
    {
        return $this->hasMany('App\Models\SmsSendUser')->whereStatus(0);
    }

    public function smsUserSuccess()
    {
        return $this->hasMany('App\Models\SmsSendUser')->whereStatus(1);
    }

}
