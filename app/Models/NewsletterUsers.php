<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterUsers extends Model
{
    protected $table = 'newsletter_users';

    protected $fillable = [
        'name', 'email', 'phone', 'status'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }



}
