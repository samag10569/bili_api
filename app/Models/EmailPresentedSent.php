<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailPresentedSent extends Model
{
    protected $table = 'email_presented_user';

    protected $fillable = [
        'newsletter_id', 'email', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\Models\EmailPresentedSent', 'email');
    }

}
