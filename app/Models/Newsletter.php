<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';

    protected $fillable = [
        'sender','subject','content','count', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function emailUser()
    {
        return $this->hasMany('App\Models\NewsletterSent');
    }

    public function emailUserFaild()
    {
        return $this->hasMany('App\Models\NewsletterSent')->whereStatus(0);
    }

    public function emailUserSuccess()
    {
        return $this->hasMany('App\Models\NewsletterSent')->whereStatus(1);
    }
}
