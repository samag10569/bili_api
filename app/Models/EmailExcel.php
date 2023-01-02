<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailExcel extends Model
{
    protected $table = 'email-excel';

    protected $fillable = [
        'user_id', 'name', 'email', 'status', 'send_email'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
