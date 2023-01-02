<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uploader extends Model
{
    protected $table = 'uploader';

    protected $fillable = [
        'id', 'url',  'title', 'image',
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
