<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSendUser extends Model
{
    protected $table = 'email_send_user';

    protected $fillable = [
        'email_send_id', 'user_id', 'status', 'type'
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

    public function emailExcel()
    {
        return $this->belongsTo('App\Models\EmailExcel', 'user_id');
    }

}
