<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSms extends Model
{
    protected $table = 'newsletters_sms';

    protected $fillable = [
        'sender','subject','content','count', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }
    public function phoneUser()
    {
        return $this->hasMany('App\Models\NewsletterSmsSent','newsletter_id');
    }

    public function phoneUserFaild()
    {
        return $this->hasMany('App\Models\NewsletterSmsSent','newsletter_id')->whereStatus(0);
    }

    public function phoneUserSuccess()
    {
        return $this->hasMany('App\Models\NewsletterSmsSent','newsletter_id')->whereStatus(1);
    }
}
