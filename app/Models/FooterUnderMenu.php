<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterUnderMenu extends Model
{
    protected $table = 'footer_under_menu';

    protected $fillable = [
        'id', 'title', 'tab_id', 'link', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }


    public function footerTab()
    {
        return $this->belongsTo('App\Models\FooterTab', 'tab_id');
    }
}
