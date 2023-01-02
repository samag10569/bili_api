<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnderMenu extends Model
{
    protected $table = 'under_menu';

    protected $fillable = [
        'id', 'title', 'tab_id', 'link', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }


    public function tab()
    {
        return $this->belongsTo('App\Models\Tab', 'tab_id');
    }
}
