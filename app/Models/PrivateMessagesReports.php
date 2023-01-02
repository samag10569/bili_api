<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessagesReports extends Model
{
    protected $table = 'private_messages_reports';

    protected $fillable = [
        'user_id','pm_id','message',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function sender()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function msg()
    {
        return $this->belongsTo('App\Models\PrivateMessages','pm_id');
    }

}
