<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    protected $table = 'tab';

    protected $fillable = [
        'id', 'title', 'link', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }


    public function underMenu()
    {
        return $this->hasMany('App\Models\UnderMenu')->whereStatus(1);
    }



}
