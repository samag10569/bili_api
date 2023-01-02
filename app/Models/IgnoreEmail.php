<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IgnoreEmail extends Model
{
    protected $table = 'ignore_email';

    protected $fillable = [
        'email', 'status', 'type', 'type_id'
    ];

    protected function getDateFormat()
    {
        return 'U';
    }

}
