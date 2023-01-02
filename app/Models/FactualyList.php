<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactualyList extends Model
{
    protected $table = 'factualy_list';

    protected $fillable = [
        'id', 'title', 'type', 'version', 'listorder', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsToMany('App\User');
    }

}
