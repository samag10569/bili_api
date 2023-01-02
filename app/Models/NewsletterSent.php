<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSent extends Model
{
    protected $table = 'newsletter_sent';

    protected $fillable = [
        'newsletter_id', 'user_id', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

    public function user()
    {
        return $this->belongsTo('App\Models\NewsletterUsers', 'uers_id');
    }

}
