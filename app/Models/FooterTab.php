<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterTab extends Model
{
    protected $table = 'footer_tab';

    protected $fillable = [
        'id', 'title', 'link', 'listorder', 'status',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function footerUnderMenu()
    {
        return $this->hasMany('App\Models\FooterUnderMenu','tab_id')->whereStatus(1);
    }

}
