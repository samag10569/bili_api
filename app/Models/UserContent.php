<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContent extends Model
{
    protected $table = 'user_content';

    protected $fillable = [
        'id','user_id', 'admin_id', 'content', 'created_at'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function admin()
    {
        return $this->belongsTo('App\User', 'admin_id','id');
    }
}
