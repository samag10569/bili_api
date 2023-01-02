<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    protected $table = 'email_send';

    protected $fillable = [
        'count', 'sender', 'subject', 'content', 'type'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function emailUser()
    {
        return $this->hasMany('App\Models\EmailSendUser');
    }

    public function emailUserFaild()
    {
        return $this->hasMany('App\Models\EmailSendUser')->whereStatus(0);
    }

    public function emailUserSuccess()
    {
        return $this->hasMany('App\Models\EmailSendUser')->whereStatus(1);
    }

}
