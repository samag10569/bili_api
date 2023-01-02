<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'title', 'ip', 'variable_id', 'admin_id', 'type', 'section'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }

}
