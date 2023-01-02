<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailPresented extends Model
{
    protected $table = 'email_presented';

    protected $fillable = [
        'sender','subject','content','count', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function emailUser()
    {
        return $this->hasMany('App\Models\EmailPresentedSent','newsletter_id');
    }

    public function emailUserFaild()
    {
        return $this->hasMany('App\Models\EmailPresentedSent','newsletter_id')->whereStatus(0);
    }

    public function emailUserSuccess()
    {
        return $this->hasMany('App\Models\EmailPresentedSent','newsletter_id')->whereStatus(1);
    }
}
